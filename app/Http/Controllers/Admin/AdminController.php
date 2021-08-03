<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
class AdminController extends Controller
{
    protected $settings;

    public function __construct() {
        $this->settings = config()->get('settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('browse-admin');
        $notallowRole = $this->settings['not_action_admin_roles'];
        array_push($notallowRole, Auth::user()->roles[0]->name);    
        $admins = Admin::whereHas('roles', function($q) use ($notallowRole) {
            $q->whereNotIn('name', $notallowRole);
        })->get();
        return view('admin.admin.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add-admin');
        $notallowRole = $this->settings['not_action_admin_roles'];
        array_push($notallowRole, Auth::user()->roles[0]->name);
        if(Auth::user()->hasRole('super_admin')){
            $roles = Role::whereNotIn('name', $notallowRole)->get();    
        }else{
            $roles = Role::whereNotIn('name', $notallowRole)->where('created_by',Auth::user()->id)->get();
        }
        
        return view('admin.admin.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('add-admin');
        $rules=[
            'name' => 'required|string',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|confirmed',
            'role' => 'required'
        ];
        $request->validate($rules);

        $user = new Admin();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->created_by = Auth::user()->id;
        if($user->save()){

            $role = Role::where('id',$request->get('role'))->first();
            $user->assignRole($role);
            flash("Admin Created!")->success();
            return redirect(route('admin.admins.index'));
        }else{
            flash("Admin not Created!")->error();
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit-admin');
        $admin = Admin::findOrFail($id);
        $notallowRole = $this->settings['not_action_admin_roles'];
        array_push($notallowRole, Auth::user()->roles[0]->name);
        if(Auth::user()->hasRole('super_admin')){
            $roles = Role::whereNotIn('name', $notallowRole)->get();    
        }else{
            $roles = Role::whereNotIn('name', $notallowRole)->where('created_by',Auth::user()->id)->get();
        }
        
        return view('admin.admin.edit',compact('roles','admin'));
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
        $this->authorize('edit-admin');
         $rules=[
            'name' => 'required|string',
            'email' => "required|email|unique:admins,email,$id,id",
            'password' => 'nullable|string|confirmed',
            'role' => 'required'
        ];
        $request->validate($rules);

        $user = Admin::findOrFail($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if($request->has('password') && !empty($request->has('password'))){
            $user->password = bcrypt($request->get('password'));    
        }
        
        if($user->save()){

            $role = Role::where('id',$request->get('role'))->first();
            $user->assignRole($role);
            flash("Admin Updated!")->success();
            return redirect(route('admin.admins.index'));
        }else{
            flash("Admin not Updated!")->error();
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-admin');
        $user = Admin::findOrFail($id);
        if($user->delete()){
            flash("Admin deleted!")->success();
        }else{
            flash("Admin not deleted!")->error();
        }
        return redirect(route('admin.admins.index'));
    }
}
