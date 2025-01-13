<?php

namespace App\Http\Controllers\Admin;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Models\{User, Order, PriceCategory};

// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Cache;

use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use Artesaos\SEOTools\Facades\SEOTools;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class  PermissionsController extends Controller
{



    public function __construct()
    {
        $this->breadcrumb = "admin_permission";
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
    public function index()     
    {
        if (!Gate::allows('manage users')) {
            return abort(401);
        }
        SEOTools::setTitle(trans('admin.permissions.title'));

        $roles = Permission::all();
        $data = [
            'items' => $roles,
            'breadcrumb' => $this->breadcrumb,
        ];

        // dd(  $data );
        return view('admin.rap.permissions.index',   $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEOTools::setTitle(trans('admin.permissions.new'));
        $data = [
            'breadcrumb' => $this->breadcrumb,
        ];
        return view('admin.rap.permissions.create',   $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionCreateRequest $request)
    {
        //
        // $input = $request->all();

        $permission             = new Permission;
        $permission->name       = $request->name;
        $permission->guard_name =  $request->guard_name;
        $permission->save();
        session()->flash('success', 'Доступ  успешно создан');

        return redirect(route('admin.rap.permissions.edit',    [$permission]));
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
        $permission        = Permission::findOrFail($id);
        SEOTools::setTitle(trans('admin.permissions.edit'));
        $data = [
            'permission' =>  $permission,
            'breadcrumb' => $this->breadcrumb,
        ];
        return view('admin.rap.permissions.edit',   $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, int $id)
    {

        // $this->check_permission('edit_permissions');

        $permission                = Permission::findOrFail($id);
        $permission->name          = $request->name;
        $permission->guard_name    = $request->guard_name;
        $permission->save();

        session()->flash('success', 'Доступ  успешно обновлен');

        return redirect(route('admin.rap.permissions.index'));
    }
}
