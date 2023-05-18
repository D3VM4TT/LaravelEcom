<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        // set the permissions for this controller
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','show']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource
     */
    public function index(Request $request){
        // fetch the roles from the database
        $roles = Role::orderBy('id','DESC')->paginate(5);

        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource
     */
    public function create(){
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        // create a new role
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        // redirect to the index page with a message
        return redirect()->route('roles.index')
            ->with('success','Role created successfully');
    }

    /**
     * Display the specified resource
     */
    public function show($id){
        // fetch the role from the database
        $role = Role::find($id);
        // fetch the permissions for this role
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('roles.show', compact('role','rolePermissions'));

    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit($id){
        // fetch the role form the database
        $role = Role::find($id);
        // fetch all the permissions
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('roles.edit', compact('role','rolePermissions'));
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, $id){

        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success','Role updated successfully');


    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy($id){
       DB::table("roles")->where('id',$id)->delete();
       return redirect()->route('roles.index')
           ->with('success','Role deleted successfully');
    }
}
