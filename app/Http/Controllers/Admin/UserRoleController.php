<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    // Show user selection & roles
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.user_roles.index', compact('users','roles'));
    }

    // Get roles of selected user (AJAX)
    public function getRoles(User $user)
    {
        return response()->json($user->roles->pluck('name'));
    }

    // Update roles for selected user
    public function updateRoles(Request $request, User $user)
    {
        $request->validate(['roles'=>'required|array']);
        $user->syncRoles($request->roles);
        return response()->json(['success'=>true,'message'=>'Roles updated successfully!']);
    }
}
