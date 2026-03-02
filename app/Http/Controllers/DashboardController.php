<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now        = Carbon::now();
        $thisMonth  = $now->copy()->startOfMonth()->toDateString();
        $lastMonth  = $now->copy()->subMonth()->startOfMonth()->toDateString();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth()->toDateString();

        // ── Monthly revenue: suscripciones + ventas de libros ─────
        $subsThisMonth = DB::table('subscriptions')
            ->join('book_plans', 'subscriptions.book_plan_fk', '=', 'book_plans.book_plan_id')
            ->where('subscriptions.start_date', '>=', $thisMonth)
            ->sum('book_plans.total_price');

        $buysThisMonth = DB::table('buys')
            ->where('date', '>=', $thisMonth)
            ->sum('total_price');

        $monthlyRevenue = $subsThisMonth + $buysThisMonth;

        // ── Mismo cálculo para el mes anterior (para el % de cambio) ─
        $subsLastMonth = DB::table('subscriptions')
            ->join('book_plans', 'subscriptions.book_plan_fk', '=', 'book_plans.book_plan_id')
            ->whereBetween('subscriptions.start_date', [$lastMonth, $lastMonthEnd])
            ->sum('book_plans.total_price');

        $buysLastMonth = DB::table('buys')
            ->whereBetween('date', [$lastMonth, $lastMonthEnd])
            ->sum('total_price');

        $lastMonthRevenue = $subsLastMonth + $buysLastMonth;

        $revenueChange = $lastMonthRevenue > 0
            ? round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : null;

        // ── Orders this month ─────────────────────────────────────
        $monthlyOrders = DB::table('buys')
            ->where('date', '>=', $thisMonth)
            ->count();

        // ── Active subscriptions ──────────────────────────────────
        $activeSubscriptions = DB::table('subscriptions')
            ->where('is_active', true)
            ->where('end_date', '>=', $now->toDateString())
            ->count();

        // ── Total users (non-admin) ───────────────────────────────
        $totalUsers = DB::table('users')
            ->where('role_id', '!=', 1)
            ->count();

        // ── Revenue chart — last 6 months (subs + buys) ──────────
        $revenueByMonth = collect();
        for ($i = 5; $i >= 0; $i--) {
            $start = $now->copy()->subMonths($i)->startOfMonth()->toDateString();
            $end   = $now->copy()->subMonths($i)->endOfMonth()->toDateString();
            $label = $now->copy()->subMonths($i)->format('M');

            $subRev = DB::table('subscriptions')
                ->join('book_plans', 'subscriptions.book_plan_fk', '=', 'book_plans.book_plan_id')
                ->whereBetween('subscriptions.start_date', [$start, $end])
                ->sum('book_plans.total_price');

            $buyRev = DB::table('buys')
                ->whereBetween('date', [$start, $end])
                ->sum('total_price');

            $revenueByMonth->push(['month' => $label, 'revenue' => $subRev + $buyRev]);
        }

        // ── Top 5 books by units sold ─────────────────────────────
        $topBooks = DB::table('order_books')
            ->whereNotNull('buy_fk')
            ->join('books', 'order_books.book_fk', '=', 'books.book_id')
            ->select(
                'books.title',
                'books.author',
                'books.image',
                DB::raw('SUM(order_books.quantity) as total_sold'),
                DB::raw('SUM(order_books.quantity * order_books.price) as total_revenue')
            )
            ->groupBy('books.book_id', 'books.title', 'books.author', 'books.image')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // ── Plans ranking ─────────────────────────────────────────
        $topPlan = DB::table('subscriptions')
            ->join('book_plans', 'subscriptions.book_plan_fk', '=', 'book_plans.book_plan_id')
            ->select('book_plans.name', DB::raw('COUNT(*) as total_subs'))
            ->groupBy('book_plans.book_plan_id', 'book_plans.name')
            ->orderByDesc('total_subs')
            ->get();

        return view('dashboard', compact(
            'monthlyRevenue',
            'revenueChange',
            'monthlyOrders',
            'activeSubscriptions',
            'totalUsers',
            'revenueByMonth',
            'topBooks',
            'topPlan'
        ));
    }
}