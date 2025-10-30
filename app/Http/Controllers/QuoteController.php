<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WipoService;
use App\Models\PricingLogic;
use Barryvdh\DomPDF\Facade\Pdf; // make sure barryvdh/laravel-dompdf is installed
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;




class QuoteController extends Controller
{
    public function create()
    {
        return view('quotes.create');
    }


    public function index()
    {
        $quotes = DB::table('quotes')
    ->where('user_id', auth()->id())
    ->select(
        'invoice_group',
        'service',
        DB::raw('GROUP_CONCAT(region ORDER BY region SEPARATOR ", ") as regions'),
        DB::raw('MAX(created_at) as created_at'),
        DB::raw('SUM(total_with_firm) as total_with_firm'),
        DB::raw('SUM(total) as total'),
        DB::raw('MAX(status) as status'),
        DB::raw('MAX(is_white_label) as is_white_label')
    )
    ->groupBy('invoice_group','service')
    ->orderByDesc(DB::raw('MAX(created_at)'))
    ->get();


        return view('quotes.index', compact('quotes'));
    }




    private function calculatePricing(array $data, PricingLogic $rule)
{
    $user = Auth::user();

    // User’s PF/TF levels
    $pfLevel = $user->pfLevel->adjustment_percent ?? 0; 
    $tfLevel = $user->tfLevel->adjustment_percent ?? 0;

    // Filing Fee (adjusted by PF level %)
    $filingFee = (float) $rule->filing_fee;
    $filingFee += $filingFee * ($pfLevel / 100);

    // Translation Fee (pages × per page fee × TF level %)
    $translationFee = 0;
    
        $translationFee = $data['pages'] * (
            (float) $rule->translation_fee + ((float) $rule->translation_fee * ($tfLevel / 100))
        );
    

    // Official Fee (flat from rule)
    $officialFee = (float) $rule->official_fee;

    // Extras (EXACT same as frontend)
    $extras = 0.0;
    if ($data['claims'] > $rule->claims_threshold) {
        $extras += ($data['claims'] - $rule->claims_threshold) * (float) $rule->excess_claim_fee;
    }
    if ($data['pages'] > $rule->pages_threshold) {
        $extras += ($data['pages'] - $rule->pages_threshold) * (float) $rule->excess_page_fee;
    }
    if ($data['drawings'] > $rule->drawing_small_threshold) {
        $extras += ($data['drawings'] - $rule->drawing_small_threshold) * (float) $rule->drawing_fee_small;
    }
    if ($data['drawings'] > $rule->drawing_large_threshold) {
        $extras += ($data['drawings'] - $rule->drawing_large_threshold) * (float) $rule->drawing_fee_large;
    }
    
    if (!empty($data['priority'])) {
        $extras += (float) ($rule->priority_fee ?? 0) * (float) $data['priority'];
    }

    // Totals
    $subtotal = $filingFee + $officialFee + $translationFee + $extras;
    $tax = round($subtotal * ((float) $rule->tax_percentage / 100), 2);
    $total = round($subtotal + $tax, 2);

    return [
        'filing_fee'      => $filingFee,
        'translation_fee' => $translationFee,
        'official_fee'    => $officialFee,
        'extra_fee'       => $extras,
        'tax'             => $tax,
        'total'           => $total,
    ];
}






    public function prepay(Request $request)
    {
        // 1. Store the quote first (reuse your existing store logic)
        // 👉 To keep DRY, you can refactor store logic into a private method.
        $quote = $this->saveQuoteFromRequest($request, $status = 'pending_payment');


        $quotes = Quote::where('invoice_group', $quote)->get();


        

    

    $grandTotal = $quotes->sum('total_with_firm');


        

        //dd($quote);

        // 2. Stripe setup
        Stripe::setApiKey(config('services.stripe.secret'));

        $checkout = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'usd',
                    'unit_amount'  => ($grandTotal * 100), // cents
                    'product_data' => [
                        'name' => 'Patent Quote #'.$quote,
                        
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('quotes.payment.success', $quote),
            'cancel_url'  => route('quotes.payment.cancel', $quote),
        ]);
        
        return redirect($checkout->url);
    }
    public function paymentSuccess($groupId)
{
    // Fetch all quotes in the same invoice group
    $quotes = Quote::where('invoice_group', $groupId)->get();

    if ($quotes->isEmpty()) {
        abort(404, 'Invoice group not found.');
    }

    // Mark all quotes in this group as paid
    Quote::where('invoice_group', $groupId)
        ->update(['status' => 'paid']);

    return view('quotes.success', [
        'quotes'     => $quotes,
        'groupId'    => $groupId,
        'grandTotal' => $quotes->sum('total_with_firm'),
    ]);
}

public function paymentCancel($groupId)
{
    // Fetch all quotes in the same group
    $quotes = Quote::where('invoice_group', $groupId)->get();

    if ($quotes->isEmpty()) {
        abort(404, 'Invoice group not found.');
    }

    // Mark them as cancelled
    Quote::where('invoice_group', $groupId)
        ->update(['status' => 'cancelled']);

    return view('quotes.cancel', [
        'quotes'     => $quotes,
        'groupId'    => $groupId,
        'grandTotal' => $quotes->sum('total_with_firm'),
    ]);
}





    





public function store(Request $request)
{
    //dd($request->all);
    $data = $request->validate([
        'service'            => 'required|string',
        'region'             => 'required|array', // will still be validated, but we’ll save multiple via breakdown
        'application_number' => 'nullable|string',
        'title'              => 'nullable|string',
        'reference_number'   => 'nullable|string',
        'applicant'          => 'nullable|string',
        'claims'             => 'required|integer|min:1',
        'pages'              => 'required|integer|min:1',
        'drawings'           => 'nullable|integer|min:0',
        'special_instructions' => 'nullable|string',
        'attachment'         => 'nullable|file|max:5120',

        'expedited'          => 'nullable|string',
        'translation'        => 'nullable',
        'priority'           => 'nullable',

        // White label
        'is_white_label'     => 'nullable|boolean',
        'firm_fees'          => 'nullable|numeric|min:0',
        'firm_logo'          => 'nullable|image|max:2048',
        'word_count'         => 'nullable',
        'filing_date'       => 'nullable|date',
        'priority_date'    => 'nullable|date',
        '30_deadline'    => 'nullable|date',
        '31_deadline'    => 'nullable|date',

        // New — frontend will send all regions + fees here
        'quote_breakdown'  => 'required|json',
    ]);


    //dd('okay');
    
    

    $data['drawings'] = $data['drawings'] ?? 0;
    $breakdown = json_decode($data['quote_breakdown'], true);

    if (!$breakdown || !is_array($breakdown)) {
        return back()->withErrors(['pricing' => 'Invalid pricing breakdown.']);
    }

    // Common group id
    $invoiceGroup = 'EIP25-' . rand(1000, 999999);


    // WIPO fetch (only once for all)
    $wipoData = null;
    if (!empty($data['application_number']) && $data['service'] === 'pct_national_phase') {
        $wipoService = new WipoService();
        $wipoData = $wipoService->fetchByApplication($data['application_number']);
    }

    // Attachments
    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('quotes/attachments'), $filename);
        $attachmentPath = 'quotes/attachments/'.$filename;
    }

    // White Label
    $isWhiteLabel = $request->boolean('is_white_label');
    $firmFees = $isWhiteLabel ? ($data['firm_fees'] ?? 0) : 0;
    $firmLogo = null;
    if ($isWhiteLabel && $request->hasFile('firm_logo')) {
        $file = $request->file('firm_logo');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('quotes/logos'), $filename);
        $firmLogo = 'quotes/logos/'.$filename;
    }

    // Save each region quote separately but linked by group
    foreach ($breakdown as $row) {
        Quote::create([
            'user_id' => Auth::id(),
            'service' => $data['service'],
            'region'  => $row['region'], // take region from breakdown
            'application_number' => $data['application_number'] ?? null,
            'title'   => $data['title'] ?? ($wipoData['title'] ?? null),
            'reference_number' => $data['reference_number'] ?? null,
            'applicant'        => $data['applicant'] ?? ($wipoData['applicant'] ?? null),
            'claims'           => $data['claims'],
            'pages'            => $data['pages'],
            'drawings'         => $data['drawings'],
            'word_count'       => $data['word_count'],
            'special_instructions' => $data['special_instructions'] ?? null,
            'attachment'       => $attachmentPath,

            'expedited'        => $data['expedited'] ?? '0',
            'translation' => isset($data['translation'])
    ? implode(',', $data['translation'])
    : 'none',
            'priority'         => $data['priority'],
            

            // Fees (from breakdown JSON)
            'filing_fee'      => $row['filing_fee'],
            'translation_fee' => $row['translation_fee'],
            'official_fee'    => $row['official_fee'],
            'extra_fee'       => $row['extra_fee'],
            'tax'             => $row['tax'],
            'total'           => $row['total'],

            'status'          => 'quoted',

            // WIPO
            'priority_date'=> $data['priority_date'] ?? null,
            'filing_date'  => $data['filing_date'] ?? null,
            'deadline_30m' => $data['30_deadline'] ?? null,
            'deadline_31m' => $data['31_deadline'] ?? null,

            // White Label
            'is_white_label'  => $isWhiteLabel,
            'firm_fees'       => $firmFees,
            'firm_logo'       => $firmLogo,
            'total_with_firm' => $row['total'],
            'firm_id'         => $isWhiteLabel ? Auth::id() : null,
            'notes'           => $row['special_rules'] ?? null,
            'language'        => $row['language'],

            // Group
            'invoice_group'   => $invoiceGroup,
           // 'pricing_json'    => json_encode($row), // save raw JSON for reference
        ]);
    }

    return redirect()->route('quotes.show.quick', $invoiceGroup)->with('success', 'Thank You! Quote created successfully. You can now download the PDF or Excel version of your quote.');
}










public function saveQuoteFromRequest(Request $request, $status = 'quoted')
{
    //dd($request->all);
    $data = $request->validate([
        'service'            => 'required|string',
        'region'             => 'required|array', // will still be validated, but we’ll save multiple via breakdown
        'application_number' => 'nullable|string',
        'title'              => 'nullable|string',
        'reference_number'   => 'nullable|string',
        'applicant'          => 'nullable|string',
        'claims'             => 'required|integer|min:1',
        'pages'              => 'required|integer|min:1',
        'drawings'           => 'nullable|integer|min:0',
        'special_instructions' => 'nullable|string',
        'attachment'         => 'nullable|file|max:5120',

        'expedited'          => 'nullable|string',
        'translation'        => 'nullable',
        'priority'           => 'nullable',

        // White label
        'is_white_label'     => 'nullable|boolean',
        'firm_fees'          => 'nullable|numeric|min:0',
        'firm_logo'          => 'nullable|image|max:2048',
        'word_count'         => 'nullable',
        'filing_date'       => 'nullable|date',
        'priority_date'    => 'nullable|date',
        '30_deadline'    => 'nullable|date',
        '31_deadline'    => 'nullable|date',

        // New — frontend will send all regions + fees here
        'quote_breakdown'  => 'required|json',
    ]);


    //dd('okay');
    
    

    $data['drawings'] = $data['drawings'] ?? 0;
    $breakdown = json_decode($data['quote_breakdown'], true);

    if (!$breakdown || !is_array($breakdown)) {
        return back()->withErrors(['pricing' => 'Invalid pricing breakdown.']);
    }

    // Common group id
    $invoiceGroup = 'EIP25-' . rand(1000, 999999);

    // WIPO fetch (only once for all)
    $wipoData = null;
    if (!empty($data['application_number']) && $data['service'] === 'pct_national_phase') {
        $wipoService = new WipoService();
        $wipoData = $wipoService->fetchByApplication($data['application_number']);
    }

    // Attachments
    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('quotes/attachments'), $filename);
        $attachmentPath = 'quotes/attachments/'.$filename;
    }

    // White Label
    $isWhiteLabel = $request->boolean('is_white_label');
    $firmFees = $isWhiteLabel ? ($data['firm_fees'] ?? 0) : 0;
    $firmLogo = null;
    if ($isWhiteLabel && $request->hasFile('firm_logo')) {
        $file = $request->file('firm_logo');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('quotes/logos'), $filename);
        $firmLogo = 'quotes/logos/'.$filename;
    }

    // Save each region quote separately but linked by group
    foreach ($breakdown as $row) {
        Quote::create([
            'user_id' => Auth::id(),
            'service' => $data['service'],
            'region'  => $row['region'], // take region from breakdown
            'application_number' => $data['application_number'] ?? null,
            'title'   => $data['title'] ?? ($wipoData['title'] ?? null),
            'reference_number' => $data['reference_number'] ?? null,
            'applicant'        => $data['applicant'] ?? ($wipoData['applicant'] ?? null),
            'claims'           => $data['claims'],
            'pages'            => $data['pages'],
            'drawings'         => $data['drawings'],
            'word_count'       => $data['word_count'],
            'special_instructions' => $data['special_instructions'] ?? null,
            'attachment'       => $attachmentPath,

            'expedited'        => $data['expedited'] ?? '0',
            'translation' => isset($data['translation'])
    ? implode(',', $data['translation'])
    : 'none',
            'priority'         => $data['priority'],

            // Fees (from breakdown JSON)
            'filing_fee'      => $row['filing_fee'],
            'translation_fee' => $row['translation_fee'],
            'official_fee'    => $row['official_fee'],
            'extra_fee'       => $row['extra_fee'],
            'tax'             => $row['tax'],
            'total'           => $row['total'],

            'status'          => $status,

            // WIPO
             'priority_date'=> $data['priority_date'] ?? null,
            'filing_date'  => $data['filing_date'] ?? null,
            'deadline_30m' => $data['30_deadline'] ?? null,
            'deadline_31m' => $data['31_deadline'] ?? null,

            // White Label
            'is_white_label'  => $isWhiteLabel,
            'firm_fees'       => $firmFees,
            'firm_logo'       => $firmLogo,
            'total_with_firm' => $row['total'],
            'firm_id'         => $isWhiteLabel ? Auth::id() : null,
            'notes'           => $row['special_rules'] ?? null,
            'language'        => $row['language'],

            // Group
            'invoice_group'   => $invoiceGroup,
           // 'pricing_json'    => json_encode($row), // save raw JSON for reference
        ]);
    }

    

    return $invoiceGroup;
}


private function saveQuoteFromRequests(Request $request, $status = 'quoted')
{
    $data = $request->validate([
        'service'  => 'required|string',
        'region'   => 'required|string',
        'application_number' => 'nullable|string',
        'title'    => 'nullable|string',
        'reference_number' => 'nullable|string',
        'applicant'=> 'nullable|string',
        'claims'   => 'required|integer|min:1',
        'pages'    => 'required|integer|min:1',
        'drawings' => 'nullable|integer|min:0',
        'special_instructions' => 'nullable|string',
        'attachment' => 'nullable|file|max:5120',

        'expedited'   => 'nullable|string',
        'translation' => 'nullable|string',
        'priority'    => 'nullable',

        'is_white_label' => 'nullable|boolean',
        'firm_fees'      => 'nullable|numeric|min:0',
        'firm_logo'      => 'nullable|image|max:2048',
        'word_count'     => 'nullable',
    ]);

    
    //$data['priority']  = $data['priority'];
    

    $rule = PricingLogic::where('region',$data['region'])
        ->where('service',$data['service'])
        ->where('status','active')
        ->first();

    if (!$rule) {
        return back()->withErrors(['pricing' => 'No pricing rule found for this selection.']);
    }

    // ✅ New pricing
    $pricing = $this->calculatePricing($data, $rule);

    $wipoData = null;
    if (!empty($data['application_number']) && $data['service'] === 'pct_national_phase') {
        $wipoService = new WipoService();
        $wipoData = $wipoService->fetchByApplication($data['application_number']);
    }

    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('quotes/attachments'), $filename);
        $attachmentPath = 'quotes/attachments/'.$filename;
    }

    $isWhiteLabel = $request->boolean('is_white_label');
    $firmFees = $isWhiteLabel ? ($data['firm_fees'] ?? 0) : 0;
    $firmLogo = null;
    if ($isWhiteLabel && $request->hasFile('firm_logo')) {
        $file = $request->file('firm_logo');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('quotes/logos'), $filename);
        $firmLogo = 'quotes/logos/'.$filename;
    }
    $totalWithFirm = $pricing['total'] + $firmFees;

    $quote = Quote::create([
        'user_id' => Auth::id(),
        'service' => $data['service'],
        'region'  => $data['region'],
        'application_number' => $data['application_number'] ?? null,
        'title'   => $data['title'] ?? ($wipoData['title'] ?? null),
        'reference_number' => $data['reference_number'] ?? null,
        'applicant'=> $data['applicant'] ?? ($wipoData['applicant'] ?? null),
        'claims'  => $data['claims'],
        'pages'   => $data['pages'],
        'drawings'=> $data['drawings'],
        'special_instructions' => $data['special_instructions'] ?? null,
        'attachment' => $attachmentPath,
        'word_count' => $data['word_count'],
        
        'translation' => $data['translation'] ?? 'none',
        'priority'    => $data['priority'],

        // Fees
        'filing_fee'      => $pricing['filing_fee'],
        'translation_fee' => $pricing['translation_fee'],
        'official_fee'    => $pricing['official_fee'],
        'extra_fee'       => $pricing['extra_fee'],
        'tax'             => $pricing['tax'],
        'total'           => $pricing['total'],

        'status'          => $status,

        'priority_date'=> $wipoData['priority_date'] ?? null,
        'filing_date'  => $wipoData['filing_date'] ?? null,
        'deadline_30m' => $wipoData['deadline_30m'] ?? null,
        'deadline_31m' => $wipoData['deadline_31m'] ?? null,

        'is_white_label'  => $isWhiteLabel,
        'firm_fees'       => $firmFees,
        'firm_logo'       => $firmLogo,
        'total_with_firm' => $totalWithFirm,
        'firm_id'         => $isWhiteLabel ? Auth::id() : null,
        'notes'           => $rule->special_rules,
    ]);

    return $quote;
}


public function download(Quote $quote)
{
    $pdf = Pdf::loadView('quotes.pdf', compact('quote'))
              ->setPaper('A4', 'portrait');

    $fileName = 'quote_'.$quote->id.'.pdf';
    return $pdf->download($fileName);
}


    public function show($groupId)
{
    $quotes = Quote::where('invoice_group', $groupId)->get();

    if ($quotes->isEmpty()) {
        abort(404, 'Invoice not found.');
    }

    $grandTotal = $quotes->sum('total_with_firm');

    return view('quotes.show', compact('quotes', 'grandTotal', 'groupId'));
}




    public function showus(Quote $quote)
    {
        return view('quotes.show', compact('quote'));
    }




    public function fetchWipo($applicationNumber)
        {
            try {
                // Example: Scraping WIPO Patentscope search page
                $html = file_get_contents("https://patentscope.wipo.int/search/en/detail.jsf?docId={$applicationNumber}");

                // Use DOMDocument / DOMXPath to parse HTML
                $doc = new \DOMDocument();
                @$doc->loadHTML($html);
                $xpath = new \DOMXPath($doc);

                // Example: Get Title
                $titleNode = $xpath->query("//h2[contains(@class,'title')]");
                $title = $titleNode->length ? trim($titleNode[0]->textContent) : null;

                // Example: Get Applicant
                $appNode = $xpath->query("//td[contains(text(),'Applicant')]/following-sibling::td");
                $applicant = $appNode->length ? trim($appNode[0]->textContent) : null;

                return response()->json([
                    'region' => 'US', // default for WIPO, or parse from page
                    'title' => $title,
                    'applicant_name' => $applicant
                ]);
            } catch (\Exception $e) {
                return response()->json(['error'=>'Could not fetch WIPO data.'], 500);
            }
        }

    public function fetchEpo($applicationNumber)
    {
        try {
            // Example: Scraping EPO Register search page
            $html = file_get_contents("https://register.epo.org/advancedSearch?lng=en");

            // Use DOMDocument / DOMXPath to parse HTML (similar to WIPO)
            $doc = new \DOMDocument();
            @$doc->loadHTML($html);
            $xpath = new \DOMXPath($doc);

            // Replace with actual selectors for title & applicant
            $title = "EP Patent Title Placeholder";
            $applicant = "EP Applicant Placeholder";

            return response()->json([
                'region' => 'EP',
                'title' => $title,
                'applicant_name' => $applicant
            ]);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Could not fetch EPO data.'], 500);
        }
    }

}

