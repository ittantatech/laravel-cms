<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
class DefaultData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Admin::where('email','ittanta@gmail.com')->first();

		if(isset($superAdmin) && $superAdmin->count()>0){
			
		}else{
			$superAdmin = new Admin;
			$superAdmin->email = 'ittanta@gmail.com';
			$superAdmin->name = 'Super Admin';
			$superAdmin->password = bcrypt('12345678');
			$superAdmin->save();
		}

		$fixed_roles = config()->get('settings.fixed_roles');
		$permissions = config()->get('permissions.permissions');
		foreach ($fixed_roles as $key=>$role){
            $newRole=Role::firstOrNew(['name'=>$key]);
            $newRole->label=$role['label'];
            $newRole->save();
        }
        $super_admin_role= Role::where('name','super_admin')->first();
        if(isset($super_admin_role) && $super_admin_role->count()>0){
            $super_admin_role->permissions()->detach();
            foreach($permissions as $type => $permission){
                foreach ($permission as $key => $value){
                    $newPermission= Permission::firstOrNew(['name'=>$key]);
                    $newPermission->label = $value;
                    $newPermission->group = $type;
                    if($newPermission->save()){
                        $super_admin_role->givePermissionTo($newPermission);
                    }
                }
            }
            $superAdmin->assignRole($super_admin_role);    
        }
        
    }
}
