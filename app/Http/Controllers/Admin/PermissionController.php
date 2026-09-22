<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Permission;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller {

    public function index() {
         $page_title = 'Permission List';
         return view('admin.permissions.list',compact('page_title'));
    }

    public function add($id = null) {
        $permission = !empty($id) ? Permission::find($id) : null;
        if ($id && !$permission) { 
            return redirect()->route('admin.permissions.list')->with('error', 'Record Not Found');
        }
        $btn_title  = $permission ? 'Update' : 'Submit';
        $page_title = $permission ? 'Update Permission' : 'Add Permission';
        return view('admin.permissions.add', compact('permission', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $input = $request->all(); 
        $id = $input['id'] ?? null;

        $rules = [
            'name' => 'required|string|unique:permissions,name,' . $id
        ];

        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }

        $permission = $id ? Permission::find($id) : new Permission();

        if($id && !$permission){
            return response()->json([
                'message'=>'Record Not Found'
            ], 404);
        }

        $permission->name = trim($input['name']);
        $permission->save();

        return response()->json([
            'success'=>true,
            'message'=> $id ? 'Permission updated successfully.' : 'Permission added successfully.'
        ]);
    }

    public function getRecords(Request $request) 
    {
        if ($request->ajax()) { 
            $query = Permission::select(['id', 'name'])->orderBy('id','desc')->get();

            return DataTables::of($query) 
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.permissions.add', $row->id);
                    $btn = '';
                    if(auth()->user()->can('permission-add')) {
                        $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a> ';
                    }
                    if(auth()->user()->can('permission-delete')) {
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

    if (!auth()->user()->can('permission-delete')) {
        return response()->json([ 
            'status' => false,
            'message' => 'Permission denied'
        ], 403);
    }

        $id = $request->get('id');
        $permission = Permission::find($id);

        if($permission){
            $permission->delete();
            return response()->json([
                'status' => true,
                'message' => 'Record Deleted successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Record Not Found'
        ]);
    }
}
