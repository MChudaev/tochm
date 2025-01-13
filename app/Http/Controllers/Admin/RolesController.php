<?php

namespace App\Http\Controllers\Admin;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Models\{User, Order, PriceCategory};

// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Cache;

use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use Artesaos\SEOTools\Facades\SEOTools;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class  RolesController extends Controller
{



    public function __construct()
    {
        $this->breadcrumb = "admin_rap";
    }
    /**
     *  Traduire un tableau simple et la retourner sous forme de clé valeur
     */
    private function translateList($lists)
    {
        foreach ($lists as $list) {
            $lists[$list] = __($list);
        }

        return $lists;
    }

    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function rap()
    {
        if (!Gate::allows('manage users')) {
            return abort(401);
        }

        $data = [
            'title' =>  "Роли и доступы",
        ];

        // dd(  $data );
        return view('admin.rap.rap',   $data);
    }

    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('manage roles')) {
            return abort(401);
        }
        // SEOTools::setTitle(trans('admin.roles.title'));

        $roles = Role::all();
        $data = [
            'title' =>  "Роли пользователей",
            'items' => $roles,
            'breadcrumb' =>  'admin_roles',
        ];

        // dd(  $data );
        return view('admin.rap.roles.index',   $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('create roles')) {
            return abort(401);
        }
        // SEOTools::setTitle(trans('admin.roles.new'));
        $data = [
            'breadcrumb' => $this->breadcrumb,
        ];
        return view('admin.rap.roles.create',   $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {

        if (!Gate::allows('edit roles')) {
            return abort(401);
        }

        $input = $request->all();
        $role             = new Role;
        $role->name       = $request->name;
        $role->guard_name =  $request->guard_name;
        $role->save();
        session()->flash('success', 'Роль  успешно создана');

        return redirect(route('admin.rap.roles.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, int $id)
    {

        // $this->check_permission('edit_roles');
        $role        = Role::findOrFail($id);
        $permissions = Permission::all();

        SEOTools::setTitle(trans('admin.roles.edit'));
        $data = [
            'title' =>  "Редактирование роли",
            'role' =>  $role,
            'permissions' =>  $permissions,
            'breadcrumb' => $this->breadcrumb,
        ];
        return view('admin.rap.roles.edit',   $data);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {

        // $this->check_permission('edit_roles');

        $role             = Role::findOrFail($id);
        $role->name       = $request->name;
        $role->guard_name = $request->guard_name;
        $role->save();

        $permissions = $request->get('permissions', []);
        $role->syncPermissions($permissions);
        session()->flash('success', 'Роль  успешно обновлена');

        return redirect(route('admin.rap.roles.index'));
    }
}
