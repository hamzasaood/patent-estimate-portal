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




class QuoteController extends Controller
{
    public function create()
    {
        return view('quotes.create');
    }


    public function index()
    {
        $quotes = Quote::where('user_id', auth()->id())
                    ->latest()
                    ->paginate(10);

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
    if (($data['translation'] ?? 'none') !== 'none') {
        $translationFee = $data['pages'] * (
            (float) $rule->translation_fee + ((float) $rule->translation_fee * ($tfLevel / 100))
        );
    }

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
    if (!empty($data['expedited'])) {
        $extras += (float) ($rule->expedited_fee ?? 0);
    }
    if (!empty($data['priority'])) {
        $extras += (float) ($rule->priority_fee ?? 0);
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


        //dd($quote);

        // 2. Stripe setup
        Stripe::setApiKey(config('services.stripe.secret'));

        $checkout = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'usd',
                    'unit_amount'  => ($quote->total_with_firm * 100), // cents
                    'product_data' => [
                        'name' => 'Patent Quote #'.$quote->id,
                        'description' => $quote->service.' in '.$quote->region,
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
    public function paymentSuccess(Quote $quote)
    {
         $quote->update(['status' => 'paid']);
         return view('quotes.success', compact('quote'));
    }

    public function paymentCancel(Quote $quote)
    {
        $quote->update(['status' => 'cancelled']);
        return view('quotes.cancel', compact('quote'));
    }




    

public function store(Request $request)
{
    $data = $request->validate([
        'service'            => 'required|string',
        'region'             => 'required|string',
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
        'translation'        => 'nullable|string',
        'priority'           => 'nullable|string',

        // White label
        'is_white_label'     => 'nullable|boolean',
        'firm_fees'          => 'nullable|numeric|min:0',
        'firm_logo'          => 'nullable|image|max:2048',
    ]);

    // Normalize
    $data['expedited'] = ($data['expedited'] ?? 'no') === 'yes';
    $data['priority']  = ($data['priority'] ?? 'no') === 'yes';
    $data['drawings']  = $data['drawings'] ?? 0;

    // Pricing Rule
    $rule = PricingLogic::where('region',$data['region'])
        ->where('service',$data['service'])
        ->where('status','active')
        ->first();

    if (!$rule) {
        return back()->withErrors(['pricing' => 'No pricing rule found for this selection.']);
    }

    // ✅ New pricing
    $pricing = $this->calculatePricing($data, $rule);

    // WIPO fetch
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
    $totalWithFirm = $pricing['total'] + $firmFees;

    // Save
    $quote = Quote::create([
        'user_id' => Auth::id(),
        'service' => $data['service'],
        'region'  => $data['region'],
        'application_number' => $data['application_number'] ?? null,
        'title'   => $data['title'] ?? ($wipoData['title'] ?? null),
        'reference_number' => $data['reference_number'] ?? null,
        'applicant'        => $data['applicant'] ?? ($wipoData['applicant'] ?? null),
        'claims'           => $data['claims'],
        'pages'            => $data['pages'],
        'drawings'         => $data['drawings'],
        'special_instructions' => $data['special_instructions'] ?? null,
        'attachment'       => $attachmentPath,

        'expedited'        => $data['expedited'],
        'translation'      => $data['translation'] ?? 'none',
        'priority'         => $data['priority'],

        // Fees
        'filing_fee'      => $pricing['filing_fee'],
        'translation_fee' => $pricing['translation_fee'],
        'official_fee'    => $pricing['official_fee'],
        'extra_fee'       => $pricing['extra_fee'],
        'tax'             => $pricing['tax'],
        'total'           => $pricing['total'],

        'status'          => 'quoted',

        // WIPO
        'priority_date'=> $wipoData['priority_date'] ?? null,
        'filing_date'  => $wipoData['filing_date'] ?? null,
        'deadline_30m' => $wipoData['deadline_30m'] ?? null,
        'deadline_31m' => $wipoData['deadline_31m'] ?? null,

        // White Label
        'is_white_label'  => $isWhiteLabel,
        'firm_fees'       => $firmFees,
        'firm_logo'       => $firmLogo,
        'total_with_firm' => $totalWithFirm,
        'firm_id'         => $isWhiteLabel ? Auth::id() : null,
    ]);

    return redirect()->route('quotes.show.quick', $quote);
}







private function saveQuoteFromRequest(Request $request, $status = 'quoted')
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
        'priority'    => 'nullable|string',

        'is_white_label' => 'nullable|boolean',
        'firm_fees'      => 'nullable|numeric|min:0',
        'firm_logo'      => 'nullable|image|max:2048',
    ]);

    $data['expedited'] = ($data['expedited'] ?? 'no') === 'yes';
    $data['priority']  = ($data['priority'] ?? 'no') === 'yes';
    $data['drawings']  = $data['drawings'] ?? 0;

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

        'expedited'   => $data['expedited'],
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




    public function show(Quote $quote)
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

