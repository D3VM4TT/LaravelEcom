<?php

namespace App\Http\Controllers;

use App\Helpers\MessageHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    private const ENTITY = 'User';

    /**
     * Display a listing of the resource
     *
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);

        return view('admin.pages.users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.pages.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.users.index')
            ->with('success', MessageHelper::createdSuccessMessage(self::ENTITY));
    }

    /**
     * Display the specified resource
     */
    public function show($id)
    {
        $user = User::find($id);

        $roles = Role::pluck('name', 'name')->all();

        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('admin.pages.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit($id)
    {
        $user = User::find($id);

        $roles = Role::pluck('name', 'name')->all();

        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('admin.pages.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($request['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($user->id);
        $user->update($input);

        // remove all the old roles
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        // assign the new roles
        $user->assignRole($input['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', MessageHelper::updatedSuccessMessage(self::ENTITY));
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('admin.users.index')
            ->with('success', MessageHelper::deletedSuccessMessage(self::ENTITY));
    }

}
