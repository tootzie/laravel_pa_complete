<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRoles;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function userAkses(Request $request)
    {

        $search = $request->input('search');

        $users = User::with('userRole')->when($search, function ($query, $search) {
            // Get all columns from the 'users' table
            $columns = Schema::getColumnListing('users');

            $query->where(function($query) use ($search, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });

            return $query;
        })->paginate(10);

        return view('user.user-akses.index', compact('users'));
    }

    public function userAksesCreate()
    {
        $roles = UserRoles::all();
        $HelperController = new HelperController();
        $users = Cache::remember('data_users', 60 * 60, function () use ($HelperController) {
            return $HelperController->get_users();
        });
        return view('user.user-akses.create', compact('roles', 'users'));
    }

    public function userAksesStore(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'ektp' => 'required|min:16|max:16',
            'user_choice' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value == '00') {
                        $fail('Please select a user.');
                    }
                },
            ],
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
            'ektp' => $request->input('ektp'),
            'nama_atasan' => $request->input('nama_atasan'),
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
        $selectedEktp = $user->ektp;
        $selectedRoleId = $user->userRole->id;
        $HelperController = new HelperController();
        $users = Cache::remember('data_users', 60 * 60, function () use ($HelperController) {
            return $HelperController->get_users();
        });

        return view('user.user-akses.edit', compact(['user', 'roles', 'selectedRoleId', 'selectedEktp', 'users']));
    }

    public function userAksesUpdate(Request $request, $id) {
        $user = User::where('id', $id)->first();

        $request->validate([
            // 'email' => 'required|string|email|max:255|unique:users',
            'ektp' => 'required|min:16|max:16',
            'user_choice' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value == '00') {
                        $fail('Please select a user.');
                    }
                },
            ],
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
            'ektp' => $request->ektp,
            'nama_atasan' => $request->input('nama_atasan'),
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

    public function userRoles(Request $request)
    {
        $search = $request->input('search');

        $roles = UserRoles::when($search, function ($query, $search) {
            // Get all columns from the 'users' table
            $columns = Schema::getColumnListing('user_roles');

            $query->where(function($query) use ($search, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });

            return $query;
        })->paginate(10);

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
