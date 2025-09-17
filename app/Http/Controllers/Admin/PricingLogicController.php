<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingLogic;

use Illuminate\Http\Request;

class PricingLogicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        $logics = PricingLogic::latest()->paginate(10);
        return view('admin.pricing.index', compact('logics'));
    }

    public function create()
    {
        return view('admin.pricing.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service'          => 'required|string',
            'region'           => 'required|string',
            'country'          => 'required',
            'language'         =>  'required',
            'priority_threshold'=> 'required',

            'drawing_fee_small'=> 'required',
            'drawing_small_threshold'=> 'required',
            'drawing_fee_large'=> 'required',
            'drawing_large_threshold'=> 'required',
            'per_sequence_page_fee'=> 'required',
            'special_rules'=> 'required',

            'official_fee'         => 'required|numeric|min:0',
            'filing_fee'         => 'required|numeric|min:0',
            'excess_claim_fee'  => 'required',
            'excess_page_fee'  => 'required',
            'claims_threshold' => 'required|integer|min:0',
            
            'pages_threshold'  => 'required|integer|min:0',
            
            
            'translation_fee'  => 'required|numeric|min:0',
           
            'priority_fee'     => 'required|numeric|min:0',
            'tax_percentage'   => 'required|numeric|min:0',
            'status'           => 'required|in:active,inactive',
        ]);
            

       $exists = \App\Models\PricingLogic::where('region', $data['region'])
        ->where('service', $data['service'])
        ->exists();

    if ($exists) {
        return back()->withErrors([
            'region' => 'A rule for this Region + Service already exists.'
        ])->withInput();
    }

    \App\Models\PricingLogic::create($data);

    return redirect()->route('pricing-logics.index')
        ->with('success', 'Pricing rule created successfully!');
}

    public function edit(PricingLogic $pricing_logic)
    {
        return view('admin.pricing.edit', compact('pricing_logic'));
    }

    public function update(Request $request, PricingLogic $pricingLogic)
{
    $data = $request->validate([
            'service'          => 'required|string',
            'region'           => 'required|string',
            'country'          => 'required',
            'language'         =>  'required',
            'priority_threshold'=> 'required',

            'drawing_fee_small'=> 'required',
            'drawing_small_threshold'=> 'required',
            'drawing_fee_large'=> 'required',
            'drawing_large_threshold'=> 'required',
            'per_sequence_page_fee'=> 'required',
            'special_rules'=> 'required',

            'official_fee'         => 'required|numeric|min:0',
            'filing_fee'         => 'required|numeric|min:0',
            'excess_claim_fee'  => 'required',
            'excess_page_fee'  => 'required',
            'claims_threshold' => 'required|integer|min:0',
            
            'pages_threshold'  => 'required|integer|min:0',
            
            
            'translation_fee'  => 'required|numeric|min:0',
           
            'priority_fee'     => 'required|numeric|min:0',
            'tax_percentage'   => 'required|numeric|min:0',
            'status'           => 'required|in:active,inactive',
        ]);

    $exists = \App\Models\PricingLogic::where('region', $data['region'])
        ->where('service', $data['service'])
        ->where('id', '<>', $pricingLogic->id) // exclude current record
        ->exists();

    if ($exists) {
        return back()->withErrors([
            'region' => 'Another rule with this Region + Service already exists.'
        ])->withInput();
    }

    $pricingLogic->update($data);

    return redirect()->route('pricing-logics.index')
        ->with('success', 'Pricing rule updated successfully!');
}

    public function destroy(PricingLogic $pricing)
    {
        $pricing->delete();
        return redirect()->route('pricing-logics.index')->with('success','Pricing Rule deleted!');
    }
}
