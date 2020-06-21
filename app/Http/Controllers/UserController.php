<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all()->pluck('name');

        return view('user_management.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $request['password'] = Hash::make($request->password);

        $user = User::create($request->all());

        $user->assignRole($request->role);

        return response()->json(['message' => 'Data berhasil tambah.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user['role'] = $user->roles()->first()->name;

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:8'
        ]);

        $user = User::findOrFail($id);

        if ($request->has('password')) {
            $request['password'] = Hash::make($request->password);
            $user->update($request->all());
        } else {
            $user->update($request->except(['password']));
        }

        $user->syncRoles($request->role);

        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (!$user->delete()) {
            session()->flash('error', 'Error!.');
        } else {
            return response()->json(['message' => 'Data berhasil dihapus.'], 200);
        }
    }

    public function dataTable()
    {
        $users = User::query();

        return DataTables::of($users)
        ->addColumn('role', function ($users) {
            return $users->roles()->first()->name;
        })
        ->addColumn('action', function ($users) {
            return view('layouts.partials._action', [
                'model' => $users,
                'edit_url' => route('user-management.edit', $users->id),
                'delete_url' => route('user-management.destroy', $users->id)
            ]);
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
