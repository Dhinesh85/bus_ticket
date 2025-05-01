<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role; // KEY : MULTIPERMISSION
use Spatie\Permission\Models\Permission; // KEY : MULTIPERMISSION

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Display a listing of the resource.
     */



    public function index()
    {
        $roles = Role::orderBy('updated_at', 'desc')->get();
        $roleId = Auth::user()->role_id;

        $permissions = DB::table('role_has_permissions')
            ->where('role_id', $roleId)->first();
        return view('roles.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
        // 1. Create Role
        $role = new Role();
        $role->name = $request->input('name');
        $role->guard_name = 'web';
        $role->save();
        
        // 2. Permissions
        $permissions = $request->input('permission_id', []);
        $addPermissions = $request->input('add_permission', []);
        $editPermissions = $request->input('edit_permission', []);
        $deletePermissions = $request->input('delete_permission', []);
        $viewPermissions = $request->input('show_permission', []);


        $insertData = [];

        foreach ($permissions as $permissionId) {
            $insertData[] = [
                'role_id' => $role->id,
                'permission_id' => $permissionId,
                'add_permission' => in_array($permissionId, $addPermissions) ? 1 : 0,
                'edit_permission' => in_array($permissionId, $editPermissions) ? 1 : 0,
                'delete_permission' => in_array($permissionId, $deletePermissions) ? 1 : 0,
                'show_permission' => in_array($permissionId, $viewPermissions) ? 1 : 0,
                
            ];
        }
        DB::table('role_has_permissions')->insert($insertData);
      
        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }catch(\Illuminate\Database\QueryException $e) { // Handle query exception
       
        return redirect()
            ->back()
            ->withInput()
            ->with('error', "error occurs failed to proceed...! " . $e->getMessage());
    } 
        

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();
        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::get();
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get()->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

     public function update(RoleUpdateRequest $request, Role $role)
     {
         // 1. Update the role name
         $role->updateOrFail([
             'name' => $request->input('name'),
         ]);
     
         // 2. Remove existing permissions for this role
         DB::table('role_has_permissions')->where('role_id', $role->id)->delete();
     
         // 3. Get the different permission arrays
         $menuPermissions = $request->input('permission', []);
         $addPermissions = $request->input('add_permission', []);
         $editPermissions = $request->input('edit_permission', []);
         $deletePermissions = $request->input('delete_permission', []);
         $showPermissions = $request->input('show_permission', []);
     
         // 4. Process all unique permission IDs from all permission types
         $allPermissionIds = array_unique(array_merge(
             $menuPermissions,
             $addPermissions,
             $editPermissions,
             $deletePermissions,
             $showPermissions
         ));
     
         // 5. Insert permissions
         foreach ($allPermissionIds as $permissionId) {
             DB::table('role_has_permissions')->insert([
                 'role_id' => $role->id,
                 'permission_id' => $permissionId,
                 'add_permission' => in_array($permissionId, $addPermissions) ? 1 : 0,
                 'edit_permission' => in_array($permissionId, $editPermissions) ? 1 : 0,
                 'delete_permission' => in_array($permissionId, $deletePermissions) ? 1 : 0,
                 'show_permission' => in_array($permissionId, $showPermissions) ? 1 : 0,
             ]);
         }
         
         // 6. Redirect back with success message
         return redirect()->route('roles.index')->with('success', 'Role updated successfully');
     }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            \Log::info(" file '" . __CLASS__ . "' , function '" . __FUNCTION__ . "' , Message : Success deleting data : " . json_encode([request()->all(), $role]));
            return redirect()->route('roles.index')
                ->withSuccess('Deleted Successfully.');
        } catch (\Illuminate\Database\QueryException $e) { // Handle query exception
            \Log::error(" file '" . __CLASS__ . "' , function '" . __FUNCTION__ . "' , Message : Error Query deleting data : " . $e->getMessage() . '');
            // You can also return a response to the user
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "error occurs failed to proceed...! " . $e->getMessage());
        } catch (\Exception $e) { // Handle any runtime exception
            \Log::error(" file '" . __CLASS__ . "' , function '" . __FUNCTION__ . "' , Message : Error deleting data : " . $e->getMessage() . '');
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "error occurs failed to proceed...! " . $e->getMessage());
        }
    }
}
