<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRoles;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userAkses()
    {
        //Get user data
        $users = User::with('userRole')->get();


        return view('user.user-akses.index', compact('users'));
    }

    public function userAksesCreate()
    {
        $roles = UserRoles::all();
        return view('user.user-akses.create', compact('roles'));
    }

    public function userAksesStore(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'role_name' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value == '00') {
                        $fail('Please select a role.');
                    }
                },
            ],
        ]);

        User::create([
            'email' => $request->input('email'),
            'id_user_roles' => $request->input('role_name'),
            'password' => encrypt('123456dummy'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('user-akses')->with('success', 'User added successfully!');
    }

    public function userAksesEdit($id) {
        $user = User::where('id', $id)->with('userRole')->first();
        $roles = UserRoles::all();
        $selectedRoleId = $user->userRole->id;
        return view('user.user-akses.edit', compact(['user', 'roles', 'selectedRoleId']));
    }

    public function userAksesUpdate(Request $request, $id) {
        $user = User::where('id', $id)->first();

        $request->validate([
            // 'email' => 'required|string|email|max:255|unique:users',
            'role_name' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value == '00') {
                        $fail('Please select a role.');
                    }
                },
            ],

        ]);

        $user->update([
            'email' => $request->email,
            'id_user_roles' => $request->role_name,
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('user-akses')->with('success', 'User edited successfully!');
    }

    public function userAksesDelete($id) {
        $user = User::where('id', $id)->first();
        $user->delete();

        return redirect()->route('user-akses')->with('success', 'User deleted successfully!');
    }

    public function userRoles()
    {

        //Get user data
        $roles = UserRoles::all();

        return view('user.user-roles.index', compact('roles'));
    }

    public function userRolesCreate()
    {
        return view('user.user-roles.create');
    }

    public function userRolesStore(Request $request)
    {
        UserRoles::create([
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('user-roles')->with('success', 'Roles added successfully!');
    }

    public function userRolesEdit($id) {
        $role = UserRoles::where('id', $id)->first();
        return view('user.user-roles.edit', compact('role'));
    }

    public function userRolesUpdate(Request $request, $id) {
        $role = UserRoles::where('id', $id)->first();

        $role->update([
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('user-roles')->with('success', 'Roles edited successfully!');
    }

    public function userRolesDelete($id) {
        $role = UserRoles::where('id', $id)->first();
        $role->delete();

        return redirect()->route('user-roles')->with('success', 'Role deleted successfully!');
    }
}
