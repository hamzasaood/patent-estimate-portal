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
        $rules = PricingLogic::latest()->paginate(10);
        return view('admin.pricing.index', compact('rules'));
    }

    public function create()
    {
        return view('admin.pricing.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
        'jurisdiction'      => 'required|string',
        'application_type'  => 'required|string',
        'base_fee'          => 'required|numeric|min:0',
        'priority_fee'      => 'nullable|numeric|min:0',
        'claims_threshold'   => 'nullable|numeric|min:0',
        'per_claim_fee'     => 'nullable|numeric|min:0',
        'per_page_fee'      => 'nullable|numeric|min:0',
        'pages_threshold'   => 'nullable|numeric|min:0',
        'per_drawing_fee'   => 'nullable|numeric|min:0',
        'translation_fee'   => 'nullable|numeric|min:0',
        'expedited_fee'     => 'nullable|numeric|min:0',
        'tax_percentage'    => 'nullable|numeric|min:0|max:100',
        'status'            => 'required|in:active,inactive',
    ]);

       $exists = \App\Models\PricingLogic::where('jurisdiction', $data['jurisdiction'])
        ->where('application_type', $data['application_type'])
        ->exists();

    if ($exists) {
        return back()->withErrors([
            'jurisdiction' => 'A rule for this Jurisdiction + Application Type already exists.'
        ])->withInput();
    }

    \App\Models\PricingLogic::create($data);

    return redirect()->route('pricing.index')
        ->with('success', 'Pricing rule created successfully!');
}

    public function edit(PricingLogic $pricing)
    {
        return view('admin.pricing.edit', compact('pricing'));
    }

    public function update(Request $request, PricingLogic $pricingLogic)
{
    $data = $request->validate([
        'jurisdiction'      => 'required|string',
        'application_type'  => 'required|string',
        'base_fee'          => 'required|numeric|min:0',
        'per_claim_fee'     => 'nullable|numeric|min:0',
        'claims_threshold'   => 'nullable|numeric|min:0',
        'priority_fee'      => 'nullable|numeric|min:0',
        'per_page_fee'      => 'nullable|numeric|min:0',
        'pages_threshold'   => 'nullable|numeric|min:0',
        'per_drawing_fee'   => 'nullable|numeric|min:0',
        'translation_fee'   => 'nullable|numeric|min:0',
        'expedited_fee'     => 'nullable|numeric|min:0',
        'tax_percentage'    => 'nullable|numeric|min:0|max:100',
        'status'            => 'required|in:active,inactive',
    ]);

    $exists = \App\Models\PricingLogic::where('jurisdiction', $data['jurisdiction'])
        ->where('application_type', $data['application_type'])
        ->where('id', '<>', $pricingLogic->id) // exclude current record
        ->exists();

    if ($exists) {
        return back()->withErrors([
            'jurisdiction' => 'Another rule with this Jurisdiction + Application Type already exists.'
        ])->withInput();
    }

    $pricingLogic->update($data);

    return redirect()->route('pricing.index')
        ->with('success', 'Pricing rule updated successfully!');
}

    public function destroy(PricingLogic $pricing)
    {
        $pricing->delete();
        return redirect()->route('pricing.index')->with('success','Pricing Rule deleted!');
    }
}
