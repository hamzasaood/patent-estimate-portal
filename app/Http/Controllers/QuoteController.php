<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WipoService;

class QuoteController extends Controller
{
    public function create()
    {
        return view('quotes.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'application_type' => 'required|string',
        'jurisdiction'     => 'required|string',
        'application_number' => 'nullable|string',
        'claims'           => 'required|integer|min:1',
        'pages'            => 'required|integer|min:1',
        'drawings'         => 'nullable|integer|min:0',
        'expedited'        => 'nullable|string',
        'translation'      => 'nullable|string',
        'priority'         => 'nullable|string',
    ]);

    // Cast options
    $data['expedited'] = ($data['expedited'] ?? 'no') === 'yes';
    $data['priority']  = ($data['priority'] ?? 'no') === 'yes';

    // --- Estimate calculation logic ---
    $base = 1000;
    $extras = 0;

    if ($data['claims'] > 20) $extras += ($data['claims'] - 20) * 30;
    if ($data['pages'] > 25)  $extras += ($data['pages'] - 25) * 5;
    if ($data['drawings'] > 0) $extras += $data['drawings'] * 12;
    if ($data['expedited']) $extras += 450;
    if ($data['priority'])  $extras += 120;
    if (($data['translation'] ?? 'none') !== 'none') $extras += $data['pages'] * 3;

    $tax = round(($base + $extras) * 0.05);
    $total = $base + $extras + $tax;

    // --- WIPO Integration ---
    $wipoData = null;
    if (!empty($data['application_number'])) {
        $wipoService = new WipoService();
        $wipoData = $wipoService->fetchByApplication($data['application_number']);
    }

    // Store in DB
    $quote = Quote::create([
        'user_id'         => Auth::id(),
        'application_type'=> $data['application_type'],
        'jurisdiction'    => $data['jurisdiction'],
        'application_number' => $data['application_number'] ?? null,
        'claims'          => $data['claims'],
        'pages'           => $data['pages'],
        'drawings'        => $data['drawings'] ?? 0,
        'expedited'       => $data['expedited'],
        'translation'     => $data['translation'] ?? 'none',
        'priority'        => $data['priority'],
        'base_fee'        => $base,
        'extra_fee'       => $extras,
        'tax'             => $tax,
        'total'           => $total,
        'status'          => 'quoted',

        // Add WIPO fields if found
        'title'           => $wipoData['title'] ?? null,
        'applicant'       => $wipoData['applicant'] ?? null,
        'priority_date'   => $wipoData['priority_date'] ?? null,
        'filing_date'     => $wipoData['filing_date'] ?? null,
        'deadline_30m'    => $wipoData['deadline_30m'] ?? null,
        'deadline_31m'    => $wipoData['deadline_31m'] ?? null,
    ]);

    return redirect()->route('quotes.show', $quote);
}


    public function show(Quote $quote)
    {
        return view('quotes.show', compact('quote'));
    }
}

