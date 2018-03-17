<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use App\Http\Requests;
use App\Models\Role;
use App\Models\Permission;
use Session;

class Roles extends Controller
{
    
    public function index() {
        if ( App::isLocale('ka') ) $langLink = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Georgian.json";
        else $langLink = "//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json";

        $data = [
            'langLink' => $langLink,
        ];

        return view( "admin.roles.roles" )->with($data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:roles,name',
            'display_name' => 'max:255',
            'description' => 'max:255',
        ]);
        
        $role = new Role();

        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;//return (array)$role;

        $role->save();
        
        Session::flash('message', 'Successfully created role!');
        
        return redirect('admin/roles');
    }
    
    public function allRoles()
    {
        //return Datatables::of(Role::query())->make(true);
        $roles = Role::select(['id', 'name', 'display_name', 'description', 'created_at', 'updated_at'])->get();
        
        return Datatables::of($roles)
            ->addColumn('action', function ($role) {
                return '<a href="roles/'.$role->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <form method="POST" action="roles/'.$role->id.'" accept-charset="UTF-8" class="pull-right">
                            <input name="_method" type="hidden" value="DELETE">
                            ' . csrf_field() . '
                            <button type="subbmit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-remove"></i> Delete</button>
                        </form>'
                        ;
            })
            ->make(true);
    }
    
    public function edit($id)
    {
        $role = Role::find($id);
        
        $data = [
            'role'=>$role,
            'permissions'=>Permission::all(),
            'checkeds'=>$role->perms()->get()->pluck('id')->all(),
        ];

        return view('admin.roles.edit')->with($data);
    }
    
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        
        $this->validate($request, [
            'name' => 'required|max:255|unique:roles,name,'.$id,
            'display_name' => 'max:255',
            'description' => 'max:255',
        ]);

        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();
        
        if ( $request->permissions ) $permissions = $request->permissions; else $permissions = [];
        $role->perms()->sync( $permissions );
        
        Session::flash('message', 'Successfully updated role!');
        return redirect('admin/roles');
    }
    
    public function destroy($id)
    {
        // delete
        $role = Role::find($id);
        $role->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the role!');
        return redirect('admin/roles');
    }
    
}
