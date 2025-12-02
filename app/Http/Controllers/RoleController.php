<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
       public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::select('roles.*');

            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($role) {
                    return '
                        <button class="btn btn-sm btn-primary editRole" data-id="' . $role->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger deleteRole" data-id="' . $role->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('roles.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        Role::create(['name' => $request->name]);

        return response()->json(['status' => true, 'message' => 'Role created successfully']);
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id
        ]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        return response()->json(['status' => true, 'message' => 'Role updated successfully']);
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        return response()->json(['status' => true, 'message' => 'Role deleted successfully']);
    }
}
