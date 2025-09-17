<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingLevel;
use Illuminate\Http\Request;

class PricingLevelController extends Controller
{
    public function index()
    {
        $levels = PricingLevel::get();
        return view('admin.pricing-levels.index', compact('levels'));
    }

    public function create()
    {
        return view('admin.pricing-levels.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'kind' => 'required',
            'adjustment_percent' => 'required|numeric|min:-100|max:100',
        ]);

        PricingLevel::create($data);
        return redirect()->route('pricing-levels.index')->with('success', 'Pricing level created successfully.');
    }

    public function edit(PricingLevel $pricingLevel)
    {
        return view('admin.pricing-levels.edit', compact('pricingLevel'));
    }

    public function update(Request $request, PricingLevel $pricingLevel)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'kind' => 'required',
            'adjustment_percent' => 'required|numeric|min:-100|max:100',
        ]);

        $pricingLevel->update($data);
        return redirect()->route('pricing-levels.index')->with('success', 'Pricing level updated successfully.');
    }

    public function destroy(PricingLevel $pricingLevel)
    {
        $pricingLevel->delete();
        return redirect()->route('pricing-levels.index')->with('success', 'Pricing level deleted successfully.');
    }
}
