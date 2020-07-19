<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Departement;
use App\Models\User;
use PDF;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function indexJobReport()
    {
        $jobs = Job::withTrashed()->get();

        return view('report.job', compact('jobs'));
    }

    public function jobReport(Request $request)
    {
        $job = Job::withTrashed()->with('departements.tasks')->findOrFail($request->job);

        $dateStart = Carbon::createFromFormat('Y-m-d H:s:i', $job->start);
        $dateEnd = Carbon::createFromFormat('Y-m-d H:s:i', $job->end);
        $rangeDayTimeline = $dateStart->diffInDays($dateEnd);

        $dateFinish = $job->deleted_at ?? null;

        $rangeFinishDay = false;
        if ($dateFinish != null) {
            $dateFinish = Carbon::createFromFormat('Y-m-d H:s:i', $job->deleted_at);
            $rangeFinishDay = $dateStart->diffInDays($dateFinish);
        }

        $pdf = PDF::loadView('report.output.job', compact('job', 'rangeDayTimeline', 'rangeFinishDay'));

        return $pdf->setPaper('a4', 'landscape')->stream();
        // return view('report.output.job', compact('job'));
    }

    public function indexPersonReport()
    {
        $persons = User::pluck('name', 'id');

        return view('report.person', compact('persons'));
    }

    public function personReport(Request $request)
    {
        $person = User::findOrFail($request->person);

        $monthYear = explode('-', $request->month);

        // dd($monthYear);

        // $personData = $person->departements->filter(function ($q) use ($monthYear) {
        //     return $q->job->created_at->year == $monthYear[0] && $q->job->created_at->format('m') == $monthYear[1];
        // });

        // dd(Job::findOrFail(3)->departements);

        // $personPic = Job::with('departements')->whereYear('created_at', $monthYear[0])->whereMonth('created_at', $monthYear[1])->whereHas('departements', function ($q) use ($person) {
        //     $q->where('user_id', $person->id);
        // })->get();

        // dd($personPic[0]->departements);

        // $personPic = Departement::with('job')->where()->whereYear('created_at', $monthYear[0])->whereMonth('created_at', $monthYear[1])->get();

        $personReport = Departement::with('users')->whereYear('created_at', $monthYear[0])->whereMonth('created_at', $monthYear[1])->whereHas('users', function ($q) use ($person) {
            $q->whereIn('users.id', [$person->id]);
        })->get();

        $personPic = Departement::where('user_id', $person->id)->get();

        // return view('report.output.person', compact('person', 'personPic', 'personReport', 'monthYear'));

        $pdf = PDF::loadView('report.output.person', compact('person', 'personPic', 'personReport', 'monthYear'));

        return $pdf->setPaper('a4', 'landscape')->stream();
    }
}
