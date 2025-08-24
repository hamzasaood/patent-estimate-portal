<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WipoService;
use App\Models\PricingLogic;
use Barryvdh\DomPDF\Facade\Pdf; // make sure barryvdh/laravel-dompdf is installed


class QuoteController extends Controller
{
    public function create()
    {
        return view('quotes.create');
    }

    

public function store(Request $request)
{
    $data = $request->validate([
        'application_type'   => 'required|string',
        'jurisdiction'       => 'required|string',
        'application_number' => 'nullable|string',
        'claims'             => 'required|integer|min:1',
        'pages'              => 'required|integer|min:1',
        'drawings'           => 'nullable|integer|min:0',
        'expedited'          => 'nullable|string',
        'translation'        => 'nullable|string',
        'priority'           => 'nullable|string',

        // White label
        'is_white_label'     => 'nullable|boolean',
        'firm_fees'          => 'nullable|numeric|min:0',
        'firm_logo'          => 'nullable|image|max:2048'
    ]);

    // Normalize
    $data['expedited'] = ($data['expedited'] ?? 'no') === 'yes';
    $data['priority']  = ($data['priority'] ?? 'no') === 'yes';
    $data['drawings']  = $data['drawings'] ?? 0;

    // -------------------------------------------------
    // 1. Pricing Logic
    // -------------------------------------------------
    $rule = PricingLogic::where('jurisdiction', $data['jurisdiction'])
                ->where('application_type', $data['application_type'])
                ->first();

    if (!$rule) {
        return back()->withErrors(['pricing' => 'No pricing rule found for this selection.']);
    }

    $base = (float) $rule->base_fee;
    $extras = 0.0;

    if ($data['claims'] > $rule->claims_threshold) {
        $extras += ($data['claims'] - $rule->claims_threshold) * (float) $rule->per_claim_fee;
    }
    if ($data['pages'] > $rule->pages_threshold) {
        $extras += ($data['pages'] - $rule->pages_threshold) * (float) $rule->per_page_fee;
    }
    if ($data['drawings'] > 0) {
        $extras += $data['drawings'] * (float) $rule->per_drawing_fee;
    }
    if ($data['expedited']) {
        $extras += (float) $rule->expedited_fee;
    }
    if ($data['priority']) {
        $extras += (float) $rule->priority_fee;
    }
    if (($data['translation'] ?? 'none') !== 'none') {
        $extras += $data['pages'] * (float) $rule->translation_fee;
    }

    $tax   = round(($base + $extras) * ($rule->tax_percentage / 100), 2);
    $total = round($base + $extras + $tax, 2);

    // -------------------------------------------------
    // 2. WIPO Integration
    // -------------------------------------------------
    $wipoData = null;
    if (!empty($data['application_number'])) {
        $wipoService = new WipoService();
        $wipoData = $wipoService->fetchByApplication($data['application_number']);
    }

    // -------------------------------------------------
    // 3. White Label (optional)
    // -------------------------------------------------
    $isWhiteLabel = $request->boolean('is_white_label');
    $firmFees = $isWhiteLabel ? ($data['firm_fees'] ?? 0) : 0;
    $firmLogo = null;

    if ($isWhiteLabel && $request->hasFile('firm_logo')) {
    $file = $request->file('firm_logo');
    $filename = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('quotes'), $filename);
    $firmLogo = 'quotes/' . $filename; // store relative path in DB
    }


    $totalWithFirm = $isWhiteLabel ? $total + $firmFees : $total;

    // -------------------------------------------------
    // 4. Store Quote
    // -------------------------------------------------
    $quote = Quote::create([
        'user_id'          => Auth::id(),
        'application_type' => $data['application_type'],
        'jurisdiction'     => $data['jurisdiction'],
        'application_number' => $data['application_number'] ?? null,
        'claims'           => $data['claims'],
        'pages'            => $data['pages'],
        'drawings'         => $data['drawings'],
        'expedited'        => $data['expedited'],
        'translation'      => $data['translation'] ?? 'none',
        'priority'         => $data['priority'],

        'base_fee'   => $base,
        'extra_fee'  => $extras,
        'tax'        => $tax,
        'total'      => $total,

        'status'     => 'quoted',

        // WIPO autofill
        'title'        => $wipoData['title'] ?? null,
        'applicant'    => $wipoData['applicant'] ?? null,
        'priority_date'=> $wipoData['priority_date'] ?? null,
        'filing_date'  => $wipoData['filing_date'] ?? null,
        'deadline_30m' => $wipoData['deadline_30m'] ?? null,
        'deadline_31m' => $wipoData['deadline_31m'] ?? null,

        // White label
        'is_white_label' => $isWhiteLabel,
        'firm_fees'      => $firmFees,
        'firm_logo'      => $firmLogo,
        'total_with_firm'=> $totalWithFirm,
        'firm_id'        => $isWhiteLabel ? Auth::id() : null,
    ]);

    return redirect()->route('quotes.show.quick', $quote);
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
}

