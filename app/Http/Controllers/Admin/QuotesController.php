<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\User;
use App\Models\PricingLogic;

use Illuminate\Http\Request;

class QuotesController extends Controller
{
    //
    public function index()
    {
        $quotes = Quote::with('user')->latest()->paginate(10);
        return view('admin.quotes.index', compact('quotes'));
    }

    public function show(Quote $quote)
    {
        $quote->load('user');
        return view('admin.quotes.show', compact('quote'));
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('quotes.index')->with('success', 'Quote deleted successfully.');
    }


    public function data()
    {
        // Counts
        $totalQuotes     = Quote::count();
        $pendingQuotes   = Quote::where('status','pending')->count();
        $completedQuotes = Quote::where('status','completed')->count();
        $rejectedQuotes  = Quote::where('status','rejected')->count();
        $users           = User::where('role','user')->count();
        $admins          = User::where('role','admin')->count();
        $pricingRules    = PricingLogic::count();

        // Recent
        $recentQuotes = Quote::latest()->take(5)->get(['id','application_type','status']);
        //$recentLogs   = \DB::table('change_logs')->latest()->take(5)->get(); // your reusable logs

        // Jurisdictions
        $jurisdictions = Quote::select('jurisdiction', \DB::raw('COUNT(*) as count'))
            ->groupBy('jurisdiction')
            ->pluck('count','jurisdiction');

        return response()->json([
            'stats' => [
                'totalQuotes' => $totalQuotes,
                'pendingQuotes' => $pendingQuotes,
                'completedQuotes' => $completedQuotes,
                'rejectedQuotes' => $rejectedQuotes,
                'users' => $users,
                'admins' => $admins,
                'pricingRules' => $pricingRules,
            ],
            'recentQuotes' => $recentQuotes,
            //'recentLogs' => $recentLogs,
            'jurisdictions' => $jurisdictions,
        ]);
    }
}
