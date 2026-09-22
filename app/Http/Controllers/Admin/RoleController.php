<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Role;
use App\Models\Permission;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller {

    public function index() {
         $page_title = 'Role List';
         return view('admin.roles.list',compact('page_title'));
    }

    public function add($id = null) {
        $role = !empty($id) ? Role::find($id) : null;
        if ($id && !$role) { 
            return redirect()->route('admin.roles.list')->with('error', 'Record Not Found');
        }
        $btn_title  = $role ? 'Update' : 'Submit';
        $page_title = $role ? 'Update Role' : 'Add Role';
        return view('admin.roles.add', compact('role', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $input = $request->all(); 
        $id = $input['id'] ?? null; 

        $rules = [
            'name' => 'required|string|unique:roles,name,' . $id
        ];

        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }

        $role = $id ? Role::find($id) : new Role();

        if($id && !$role){
            return response()->json([
                'message'=>'Record Not Found'
            ], 404);
        }

        $role->name = trim($input['name']);
        $role->save();

        return response()->json([
            'success'=>true,
            'message'=> $id ? 'Role updated successfully.' : 'Role added successfully.'
        ]);
    }

    public function getRecords(Request $request) 
    {
        if ($request->ajax()) { 
            $query = Role::select(['id', 'name'])->orderBy('id','desc')->get();

            return DataTables::of($query) 
                ->addIndexColumn() 
                ->addColumn('action', function ($row) { 
                    $editUrl = route('admin.roles.add', $row->id);
                    $btn = '';
                    if(auth()->user()->can('role-add')) {
                        $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a> ';
                    } 
                    if(auth()->user()->can('role-delete')) {
                        $btn .= '<a title="Delete Record" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

   
    public function delete(Request $request)
{

 if (!auth()->user()->can('role-delete')) {
        return response()->json([ 
            'status' => false,
            'message' => 'Permission denied'
        ], 403);
    }

    $id = $request->get('id');

    if ($id == 1) { 
        return response()->json([
            'status' => false,
            'message' => 'Super Admin role cannot be deleted.'
        ]);
    } 

    $role = Role::find($id);

    if (!$role) {
        return response()->json([
            'status' => false,
            'message' => 'Record Not Found'
        ]);
    }

    if (strtolower($role->name) === 'admin') {
        return response()->json([
            'status' => false,
            'message' => 'Admin role cannot be deleted.'
        ]);
    }

    $role->delete();

    return response()->json([
        'status' => true,
        'message' => 'Record Deleted successfully'
    ]);
}


    // Centralized Assign Permissions Page
    public function assignPermissionsPage(Request $request) {
        $roles = Role::orderBy('name')->get();
        $permissions = Permission::all();
        $page_title = 'Assign Permissions';
        $selected_role_id = $request->query('role_id', '');
        
        return view('admin.roles.assign_permissions', compact('roles', 'permissions', 'selected_role_id', 'page_title'));
    }

    public function getRolePermissions(Request $request) {
        $role_id = $request->post('role_id');
        $role = Role::find($role_id);
        
        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Role not found'], 404);
        }

        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return response()->json(['success' => true, 'data' => $rolePermissions]);
    }

    public function savePermissions(Request $request) {
        $role_id = $request->input('role_id');
        $role = Role::find($role_id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a valid role.'
            ], 422);
        }

        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);
        
        return response()->json([
            'success' => true,
            'message' => 'Permissions assigned successfully.'
        ]);
    }
}
