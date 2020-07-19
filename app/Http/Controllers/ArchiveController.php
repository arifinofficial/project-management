<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class ArchiveController extends Controller
{
    public function index()
    {
        $jobs = Job::onlyTrashed()->orderBy('created_at', 'DESC')->paginate(9);
        
        return view('archive.index', compact('jobs'));
    }

    public function restore($id)
    {
        $job = Job::onlyTrashed()->findOrFail($id);

        $job->restore();

        return redirect()->back()->with(['success' => 'Data berhasil ubah menjadi aktif']);
    }
}
