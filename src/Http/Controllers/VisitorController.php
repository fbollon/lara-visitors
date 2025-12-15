<?php

namespace Fbollon\LaraVisitors\Http\Controllers;

use Carbon\Carbon;
use Fbollon\LaraVisitors\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class VisitorController extends BaseController
{
    public function dashboard(Request $request)
    {
        $start = $request->input('start_date', now()->subDays(7));
        $end = $request->input('end_date', now());

        $visitsTable = config('laravisitors.visits_table');
        $userModel = config('laravisitors.user_model');
        $userTable = (new $userModel)->getTable();
        
        $totalVisits = Visit::dateRange($start, $end)->count();

        $uniqueVisits = Visit::dateRange($start, $end)
            ->distinct('ip')
            ->count('ip');

        $uniqueIdentifiedVisits = Visit::dateRange($start, $end)
            ->distinct('visitor_id')
            ->count('visitor_id');

        $popularPages = Visit::dateRange($start, $end)
            ->select('url', DB::raw('count(*) as visits'))
            ->groupBy('url')
            ->orderBy('visits', 'desc')
            ->limit(10)
            ->get();

        $visitsOverTime = Visit::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as visits')
            ->dateRange($start, $end)
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at) ASC')
            ->get();

        $browserStats = Visit::query()
            ->select('browser', DB::raw('COUNT(*) as visits'))
            ->dateRange($start, $end)
            ->groupBy('browser')
            ->orderBy('visits', 'desc')
            ->get();

        $deviceStats = Visit::query()
            ->select('device', DB::raw('COUNT(*) as visits'))
            ->dateRange($start, $end)
            ->groupBy('device')
            ->orderBy('visits', 'desc')
            ->get();

        $userStats = Visit::query()
            ->leftJoin($userTable, $visitsTable.'.visitor_id', '=', $userTable.'.id')
            ->select($userTable.'.name as user_name', DB::raw('count(*) as visits'))
            ->dateRange($start, $end)     
            ->whereNotNull($visitsTable.'.visitor_id')
            ->groupBy($userTable.'.name')
            ->orderBy('visits', 'desc')
            ->get();

        $onlineVisitors = visitor()->onlineVisitors($userModel);

        return view('laravisitors::dashboard', compact(
            'totalVisits',
            'uniqueVisits',
            'uniqueIdentifiedVisits',
            'popularPages',
            'visitsOverTime',
            'browserStats',
            'deviceStats',
            'userStats',
            'onlineVisitors',
            'start',
            'end'
        ));
    }

    public function export(Request $request)
    {
        // Systematically convert to Carbon
        $start = Carbon::parse($request->input('start_date', now()->subDays(7)));
        $end   = Carbon::parse($request->input('end_date', now()));

        $visitsTable = config('laravisitors.visits_table');
        $userModel = config('laravisitors.user_model');
        $userTable = (new $userModel)->getTable();

        $visits = Visit::query()
            ->leftJoin($userTable, "$visitsTable.visitor_id", '=', "$userTable.id")
            ->select(
                "$visitsTable.url",
                "$visitsTable.browser",
                "$visitsTable.device",
                "$visitsTable.ip",
                "$visitsTable.created_at",
                "$userTable.name as user_name"
            )
            ->dateRange($start, $end)
            ->orderBy("$visitsTable.created_at", 'asc')
            ->get();

        // File name based on reliable Carbon dates
        $filename = "statistiques_visites_{$start->format('Y-m-d')}_a_{$end->format('Y-m-d')}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        // CSV generation in stream
        $callback = function () use ($visits) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, ['URL', 'Navigateur', 'Device', 'IP', 'Date de visite', 'Utilisateur']);

            // Lines
            foreach ($visits as $visit) {
                fputcsv($file, [
                    $visit->url,
                    $visit->browser,
                    $visit->device,
                    $visit->ip,
                    $visit->created_at,
                    $visit->user_name ?? 'Anonyme',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
