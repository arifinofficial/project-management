<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);

        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:1|string',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user = User::findOrFail($request->id);

        $request['password'] = $request->password === null ? $user->password : $request->password;
        
        $user->update($request->except('id'));

        return redirect()->back()->with(['success' => 'Profile berhasil di perbaharui']);
    }
}
