<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use App\Http\Requests;
use App\Models\Permission;
use App\Models\Role;
use Session;

class Permissions extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( App::isLocale('ka') ) $langLink = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Georgian.json";
        else $langLink = "//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json";

        $data = [
            'langLink' => $langLink,
        ];

        return view( "admin.permissions.permissions" )->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('admin/permissions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:permissions,name',
            'display_name' => 'max:255',
            'description' => 'max:255',
        ]);
        
        $permission = new Permission();

        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;

        $permission->save();
        
        Session::flash('message', 'Successfully created permission!');
        
        return redirect('admin/permissions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin/permissions/'.$id.'/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        
        $data = [
            'permission'=>$permission,
            'roles'=>Role::all(),
            'checkeds'=>$permission->roles()->get()->pluck('id')->all(),
        ];

        return view('admin.permissions.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        
        $this->validate($request, [
            'name' => 'required|max:255|unique:permissions,name,'.$id,
            'display_name' => 'max:255',
            'description' => 'max:255',
        ]);

        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->save();
        
        if ( $request->roles ) $roles = $request->roles; else $roles = [];
        $permission->roles()->sync( $request->roles );
        
        Session::flash('message', 'Successfully updated permission!');
        return redirect('admin/permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        $permission = Permission::find($id);
        $permission->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the permission!');
        return redirect('admin/permissions');
    }
    
    // datatables
    
    public function allPermissions()
    {
        $permissions = Permission::select(['id', 'name', 'display_name', 'description', 'created_at', 'updated_at'])->get();
        
        return Datatables::of($permissions)
            ->addColumn('action', function ($permission) {
                return '<a href="permissions/'.$permission->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <form method="POST" action="permissions/'.$permission->id.'" accept-charset="UTF-8" class="pull-right">
                            <input name="_method" type="hidden" value="DELETE">
                            ' . csrf_field() . '
                            <button type="subbmit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-remove"></i> Delete</button>
                        </form>'
                        ;
            })
            ->make(true);
    }
}
