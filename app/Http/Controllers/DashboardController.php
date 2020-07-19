<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalJob = Job::count();
        $totalArchive = Job::onlyTrashed()->count();
        $totalUser = User::count();
        $totalTask = Task::count();

        $totalJobChart = [];
        $totalTaskChart = [];
        for ($i=1; $i <= 12 ; $i++) {
            $monthName = substr(date("F", mktime(null, null, null, $i)), 0, 3);

            $totalJobChart[$monthName] = Job::whereYear('start', date('Y'))->whereMonth('start', $i)->count();

            $totalTaskChart[$monthName] = 0;

            if ($totalJobChart[$monthName] > 0) {
                $dd = Job::whereYear('start', date('Y'))->whereMonth('start', $i)->with(['departements' => function ($query) use (&$totalTaskChart, &$monthName) {
                    $totalTaskChart[$monthName] = $query->withCount('tasks')->count();
                }])->get();
            }
        }

        $resTotalMonth = json_encode(array_keys($totalJobChart));
        $resTotalJob = json_encode(array_values($totalJobChart));
        $resTotalTask = json_encode(array_values($totalTaskChart));

        return view('dashboard.index', compact('totalJob', 'totalArchive', 'totalUser', 'totalTask', 'resTotalMonth', 'resTotalJob', 'resTotalTask'));
    }
}
