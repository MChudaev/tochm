<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\AdminPassUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        if (!Gate::allows('manage users')) {
            return abort(401);
        }
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('manage users')) {
            return abort(401);
        }
        $roles       = Role::all();
        $permissions = Permission::all();

        $data = [
            'title' => "Создание пользователя",
            'roles' => $roles,
            'permissions' => $permissions,
        ];

        return view('admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        if (!Gate::allows('manage users')) {
            return abort(401);
        }
        $temp             = $request->all();
        $temp['password'] = Hash::make($request->password);
        $user             = User::create($temp);

        $this->syncPermissions($request, $user);

        session()->flash('success', 'Пользователь успешно сохранен');
        return redirect(route('admin.user.index'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (!Gate::allows('manage users')) {
            return abort(401);
        }
        $roles       = Role::all();
        $permissions = Permission::all();

        $data = [
            'title' => "Редактирование пользователя",
            'roles' => $roles,
            'permissions' => $permissions,
            'user' => $user,

        ];

        return view('admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if (!Gate::allows('manage users')) {
            return abort(401);
        }
        $input = $request->except(['roles', 'permissions']);

        $input['password'] = Hash::make($request->password);
        $request->filled('active') ? $input['active'] = 1 : $input['active'] = 0;
        $request->filled('is_admin') ? $input['is_admin'] = 1 : $input['is_admin'] = 0;

        $user->update($input);
        $this->syncPermissions($request, $user);
        //  TODO сделать копирование пермишенов роли! Или не надо?
        session()->flash('success', 'Пользователь успешно обновлен');
        return redirect(route('admin.user.index'));

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        if (!Gate::allows('manage users')) {
            return abort(401);
        }

        // TODO удаление!

    }
    public function updatepass(AdminPassUpdateRequest $request)
    {
        if (!Gate::allows('manage users')) {
            return abort(401);
        }

        $user = User::find($request->id);
        if (!(Hash::check($request->get('oldpass'), $user->password))) {
            // The passwords matches
            session()->flash('error', 'Ваш текущий пароль не совпадает с введенным вами. Попробуйте еще раз.');

            return redirect()->back();
        }

        if (strcmp($request->get('oldpass'), $request->get('newpass')) == 0) {
            session()->flash('error', 'Новый пароль не может быть равен старому. Попробуйте другой пароль.');

            return redirect()->back();
        }

        $user->password = bcrypt($request->get('newpass'));
        $user->save();
        session()->flash('success', 'Пароль удачно обновлен');


        return redirect(route($this->path_admin . '.index'));
    }

    private function syncPermissions(Request $request, $user)
    {
        $roles       = $request->get('roles', []);
        $permissions = $request->get('permissions', []);
        $roles       = Role::find($roles);

        if (!$user->hasAllRoles($roles)) {
            $user->permissions()->sync([]);
        } else {
            $user->syncPermissions($permissions);
        }
        $user->syncRoles($roles);

        return $user;
    }
}
