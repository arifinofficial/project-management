<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use App\Models\Departement;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\JobRequest;
use App\Http\Resources\JobResource;
use DB;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create job', ['only' => ['create']]);
        $this->middleware('permission:delete job', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'DESC')->paginate(9);

        return view('job.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view('job.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        DB::beginTransaction();
        
        try {
            $jobModel = Job::create([
                'user_id' => auth()->user()->id,
                'name' => $request->job['name'],
                'description' => $request->job['description'],
                'start' => $request->job['start'],
                'end' => $request->job['end']
            ]);

            $jobModel->categories()->attach($request->job['category']);

            foreach ($request->departements as $departement) {
                $departementModel = Departement::create([
                    'name' => $departement['name'],
                    'job_id' => $jobModel->id,
                    'user_id' => $departement['user_id'],
                ]);

                $departementModel->users()->attach($departement['users']);
    
                foreach ($departement['tasks'] as $task) {
                    Task::create([
                        'departement_id' => $departementModel->id,
                        'name' => $task['name'],
                        'description' => $task['description'],
                        'status' => $task['status']
                    ]);
                }
            }

            DB::commit();

            $route = route('job.index');

            session()->flash('success', 'Data sukses ditambah.');

            return response()->json(['status' => 'success', 'url' => $route], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        $job = $job->load('departements.tasks');

        $job->departements = $job->departements->map(function ($q) {
            $q['pic'] = User::findOrFail($q->user_id)->name;

            // $q->load('users');

            $q['users'] = $q->users()->pluck('user_id');

            return $q;
        });

        return response()->json([
            'success' => true,
            'data' => new JobResource($job),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $id = $id;

        return view('job.edit', compact('categories', 'users', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, $id)
    {
        $job = Job::findOrFail($id);

        DB::beginTransaction();

        try {
            $job->update([
                'name' => $request->job['name'],
                'description' => $request->job['description'],
                'start' => $request->job['start'],
                'end' => $request->job['end']
            ]);

            $job->categories()->sync($request->job['category']);

            // Iteration update departement
            foreach ($request->departements as $departement) {
                $insertDepartement = Departement::updateOrCreate(
                    ['id' => $departement['id']],
                    [
                        'user_id' => $departement['user_id'],
                        'job_id' => $id,
                        'name' => $departement['name'],
                    ]
                );

                // if (count($departement['users']) == count($departement['users'], COUNT_RECURSIVE)) {
                //     $userId = $departement['users'];
                // } else {
                //     $userId = collect($departement['users'])->map(function ($q) {
                //         return $q['id'];
                //     });
                // }

                $userId = $departement['users'];
                    
                $insertDepartement->users()->sync($userId);

                // Iteration update task
                foreach ($departement['tasks'] as $task) {
                    Task::updateOrCreate(
                        ['id' => $task['id']],
                        [
                            'departement_id' => $insertDepartement->id,
                            'name' => $task['name'],
                            'description' => $task['description'],
                            'status' => $task['status']
                        ]
                    );
                }
            }

            DB::commit();

            session()->flash('success', 'Data sukses diubah.');

            return response()->json(['status' => 'success'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $job->delete();

        $route = route('job.index');

        session()->flash('success', 'Data sukses dihapus.');

        return response()->json(['status' => 'success', 'url' => $route], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  object  $job, departement
     * @return \Illuminate\Http\Response
     */
    public function destroyDepartement(Job $job, Departement $departement)
    {
        $this->authorize('showModal', $departement);

        $departement->delete();

        session()->flash('success', 'Data sukses dihapus.');

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  object  $job, $departement, $task
     * @return \Illuminate\Http\Response
     */
    public function destroyTask(Job $job, Departement $departement, Task $task)
    {
        $task->delete();

        return response()->json(['status' => 'success', 'message' => 'Data sukses dihapus.'], 200);
    }

    /**
     * Policy for create new departement
     *
     * @param  object  $job, $departement
     * @return boolean
     */
    public function checkDepartementCreatePolicy(Job $job)
    {
        // dd($departement);
        $this->authorize('createDepartement', $job);

        return true;
    }

    /**
     * Policy for departement
     *
     * @param  object  $job, $departement
     * @return boolean
     */
    public function checkDepartementPolicy(Job $job, Departement $departement)
    {
        $this->authorize('showModal', $departement);

        return true;
    }
}
