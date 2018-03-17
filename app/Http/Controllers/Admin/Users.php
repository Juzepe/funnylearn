<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use App\Http\Requests;
use App\User;
use App\Models\Role;
use Session;
use Auth;

class Users extends Controller
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

        return view( "admin.users.users" )->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('admin/users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        
        if ( !Auth::user()->can('appoint_admin') && $user->can('appoint_manager') ) {
            Session::flash('message', 'You have no permission edit this user!');
            
            return redirect('admin/users');
        }
        
        $data = [
            'user'=>$user,
            'roles'=>Role::all(),
            'checkeds'=>$user->roles()->get()->pluck('id')->all(),
        ];

        return view('admin.users.edit')->with($data);
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
        $user = User::find($id);
        
        if ( !Auth::user()->can('appoint_admin') && $user->can('appoint_manager') ) {
            Session::flash('message', 'You have no permission edit this user!');
            
            return redirect('admin/users');
        }
        
        if ( $request->roles ) $roles = $request->roles; else $roles = [];
        $user->roles()->sync( $request->roles );
        
        Session::flash('message', 'Successfully updated user!');
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect('admin/users');
    }
    
    // datatables
    
    public function allUsers()
    {
        $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at'])->get();
        
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return '<a href="users/'.$user->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->make(true);
    }
}
