<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\User;
use App\Models\PricingLogic;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


use Illuminate\Http\Request;

class QuotesController extends Controller
{
    //
    public function index()
    {
        $quotes = Quote::select(
            'invoice_group',
            'service',
            'user_id',
            \DB::raw('MAX(firm_fees) as firm_fees'),
            \DB::raw('GROUP_CONCAT(region SEPARATOR ", ") as regions'),
            \DB::raw('SUM(total_with_firm) as total_with_firm'),
            \DB::raw('SUM(total) as total'),
            \DB::raw('MAX(status) as status'),
            \DB::raw('MAX(title) as title'),
            \DB::raw('MAX(created_at) as created_at')
        )
        ->with('user') // eager load user
        ->groupBy('invoice_group','service','user_id')
        ->get();

        return view('admin.quotes.index', compact('quotes'));
    }

    public function show($groupId)
    {
        $quotes = Quote::with('user')
            ->where('invoice_group', $groupId)
            ->get();

        if ($quotes->isEmpty()) {
            abort(404, 'Quote group not found.');
        }

        $q0 = $quotes->first();
        $user = $q0->user;

       


        // Grand total
        $grandTotal = $quotes->sum(fn($q) =>
            $q->is_white_label && $q->total_with_firm ? $q->total_with_firm : $q->total
        );

        return view('admin.quotes.show', compact('quotes', 'groupId', 'q0', 'user', 'grandTotal'));
    }


public function fetchall()
{
    // ✅ Fetch all quotes (you can modify the query as needed)
    $quotes = Quote::select(
            'invoice_group',
            'service',
            'user_id',
            \DB::raw('GROUP_CONCAT(region SEPARATOR ", ") as regions'),
            \DB::raw('SUM(total_with_firm) as total_with_firm'),
            \DB::raw('SUM(total) as total'),
            \DB::raw('MAX(status) as status'),
            \DB::raw('MAX(title) as title'),
            \DB::raw('MAX(created_at) as created_at')
        )
        ->with('user') // eager load user
        ->groupBy('invoice_group','service','user_id')
        ->where('created_at', '>=', Carbon::now()->subDay())
        ->latest('created_at')
         
        ->get();

    // ✅ Return as JSON for your JS
    return response()->json($quotes);
}


    public function destroy($groupId)
{
    Quote::where('invoice_group', $groupId)->delete();

    return redirect('/admin/quotes')
        ->with('success', 'Quotes deleted successfully.');
}


    public function data()
{
    // Stats (grouped by invoice_group)
    $stats = [
        'totalQuotes'     => Quote::distinct('invoice_group')->count('invoice_group'),
        'pendingQuotes'   => Quote::where('status', 'pending_payment')->distinct('invoice_group')->count('invoice_group'),
        'completedQuotes' => Quote::where('status', 'paid')->distinct('invoice_group')->count('invoice_group'),
        'quotedQuotes'    => Quote::where('status', 'quoted')->distinct('invoice_group')->count('invoice_group'),
        'users'           => User::where('role','user')->count(),
        'admins'          => User::where('role','admin')->count(),
        'pricingRules'    => PricingLogic::count(),
    ];

    // Grouped by region
    $jurisdictions = Quote::select('region', DB::raw('COUNT(DISTINCT invoice_group) as total'))
        ->groupBy('region')
        ->pluck('total','region');

    // Grouped by language
    $languages = Quote::select('language', DB::raw('COUNT(DISTINCT invoice_group) as total'))
        ->groupBy('language')
        ->pluck('total','language');

    // 📅 Grouped by month (using invoice_group)
    $monthly = Quote::select(
            DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"),
            DB::raw("COUNT(DISTINCT invoice_group) as total")
        )
        ->groupBy('month')
        ->orderByRaw("MIN(created_at)")
        ->pluck('total','month');

    // Users grouped by TF/PF levels
    $levels = \DB::table('pricing_levels as pl')
        ->leftJoin('users as u1', 'u1.tf_level_id', '=', 'pl.id')
        ->leftJoin('users as u2', 'u2.pf_level_id', '=', 'pl.id')
        ->select(
            'pl.id',
            'pl.name',
            'pl.kind',
            'pl.adjustment_percent',
            \DB::raw('COUNT(DISTINCT u1.id) as tf_users'),
            \DB::raw('COUNT(DISTINCT u2.id) as pf_users')
        )
        ->groupBy('pl.id', 'pl.name', 'pl.kind', 'pl.adjustment_percent')
        ->get();

    $chartData = $levels->map(function($level) {
        return [
            'label' => $level->name . ' (' . $level->adjustment_percent . '%)',
            'kind'  => strtoupper($level->kind), 
            'users' => $level->kind === 'TF' ? $level->tf_users : $level->pf_users,
        ];
    });

    // Recent grouped quotes
    $recentQuotes = Quote::select('invoice_group', 'service', 'status', DB::raw('GROUP_CONCAT(region) as regions'), DB::raw('MIN(created_at) as created_at'))
        ->groupBy('invoice_group','service','status')
        ->latest('created_at')
        ->take(5)
        ->get();

    return response()->json([
        'stats'         => $stats,
        'jurisdictions' => $jurisdictions,
        'languages'     => $languages,
        'monthly'       => $monthly,
        'pricingLevels' => $chartData,
        'recentQuotes'  => $recentQuotes,
    ]);
}


}
