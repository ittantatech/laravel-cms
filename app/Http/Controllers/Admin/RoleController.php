<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
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
    public function index() {
        $this->authorize('browse-role');
        $not_allowed_roles = $this->settings['not_action_admin_roles'];
        array_push($not_allowed_roles, Auth::user()->roles[0]->name);
        $roles = Role::whereNotIn('name', $not_allowed_roles);
        if(Auth::user()->hasRole('super_admin')){
            $roles = $roles->get();
        }else{
            $roles = $roles->where('created_by',Auth::user()->id)->get();
        }
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('add-role');
        $permission_ids = Auth::user()->roles[0]->permissions->pluck('id');
        $permissions = Permission::whereIn('id', $permission_ids)->get()->groupBy('group');
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->authorize('add-role');
        $rules = [
            'name' => 'required|unique:roles,name|alpha_dash|min:3|max:190',
            'label' => 'required|min:3|max:190',
            'permission' => 'required',
        ];

        $request->validate($rules);
        $role = new Role;
        $role->name = $request->get('name');
        $role->created_by = Auth::user()->id;
        $role->label = $request->get('label');
        if ($role->save()) {
            $role->permissions()->sync($request->get('permission'));
            flash('Role Created!')->success();
        } else {
            flash('Error in creating role!')->error();
        }
        return redirect(route('admin.role.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $this->authorize('edit-role');
        $role = Role::findOrFail($id);
        if(!Auth::user()->hasRole('super_admin')){
            if(Auth::user()->id != $role->created_by){
                return redirect()->back();
            }
        }
        $permission_ids = Auth::user()->roles[0]->permissions->pluck('id');
        $permissions = Permission::whereIn('id', $permission_ids)->get()->groupBy('group');
        return view('admin.roles.update', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->authorize('edit-role');
        $rules = [
            'label' => 'required|min:3|max:190',
        ];

        $request->validate($rules);

        $role = Role::findOrFail($id);
        if(!Auth::user()->hasRole('super_admin')){
            if(Auth::user()->id != $role->created_by){
                return redirect()->back();
            }
        }
        $role->label = $request->get('label');
        //$role->created_by = Auth::user()->id;
        if ($role->save()) {
            flash('Role Updated!')->success();
            $role->permissions()->sync($request->get('permission'));
        } else {
            flash('Error in updating role!')->error();
        }
        return redirect(route('admin.role.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $this->authorize('delete-role');
        $role = Role::findOrFail($id);
        if(!Auth::user()->hasRole('super_admin')){
            if(Auth::user()->id != $role->created_by){
                return redirect()->back();
            }
        }
        $role->delete();
        flash('Role deleted!')->success();
        return redirect(route('admin.role.index'));
    }
}
