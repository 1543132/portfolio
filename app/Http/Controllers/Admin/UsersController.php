<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('can:manageUsers, App\User');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index')->with('users', User::paginate(10));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (Auth::user()->id == $user->id) {
            return redirect()->route('users.index')->with('status', 'You cannot edit yourself');
        }

        return view('admin.users.edit', [
            'model' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->id == $user->id) {
            return redirect()->route('users.index')->with('status', 'You cannot edit yourself');
        }

        $user->roles()->sync($request->roles);

        return redirect()->route('users.index')->with('status', $user->name . ' was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
