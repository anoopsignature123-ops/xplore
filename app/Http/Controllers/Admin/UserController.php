<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\User;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function index() {
         $page_title = 'Users List';
         $roles = Role::all();
         return view('admin.users.list', compact('page_title', 'roles'));
    }
    

    public function add($id = null) {
        $user = !empty($id) ? User::find($id) : null;
        if ($id && !$user) { 
            return redirect()->route('admin.users.list')->with('error', 'Record Not Found');
        }
        $btn_title  = $user ? 'Update' : 'Submit';
        $page_title = $user ? 'Update User' : 'Add User';
        $roles = Role::all();
        $userRole = $user ? $user->roles->pluck('name')->first() : '';

        return view('admin.users.add', compact('user', 'btn_title', 'page_title', 'roles', 'userRole'));
    }


    public function save(Request $request)
    {
        $input = $request->all(); 
        $id = $input['id'] ?? null;

        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => $id ? 'nullable|min:6' : 'required|min:6',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png',
            'status' => 'required|in:Active,Inactive,Blocked',
            'role' => 'required|exists:roles,name'
        ];

        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }

        $user = $id ? User::find($id) : new User();

        if($id && !$user){
            return response()->json([
                'message'=>'Record Not Found'
            ], 404);
        }

        $user->name = trim($input['name']);
        $user->email = trim($input['email']);
        $user->status = $input['status'];
        $user->raw_password = trim($input['password']);
        
        if (!empty($input['password'])) {
            $user->password = Hash::make($input['password']);
        }

        if ($request->hasFile('profile_pic')) {
            $fileName = $request->file('profile_pic');
            $uploaded = uploadImage(
                $fileName,
                'user',
                $request->input('old_profile_pic')
            );
            $user->profile_pic = $uploaded['image'] ?? '';
        }

        $user->save();

        // Assign Role
        $user->syncRoles([$input['role']]);

        return response()->json([
            'success'=>true,
            'message'=> $id ? 'User updated successfully.' : 'User added successfully.'
        ]);
    }



    public function getRecords(Request $request) 
    {
        if ($request->ajax()) {     
             $query = User::with('roles:id,name')->select(['id', 'name', 'email', 'profile_pic', 'status', 'created_at']);
            // Filters
            if ($request->filled('role')) {
                $role = $request->role;
                $query->whereHas('roles', function($q) use ($role) {
                    $q->where('name', $role);
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $query->orderBy('id', 'desc');

            return DataTables::of($query) 
                ->addIndexColumn()
                ->editColumn('profile_pic', function ($row) {
                    if (!empty($row->profile_pic)) {
                        $imgUrl = asset($row->profile_pic);
                        return '<a href="' . $imgUrl . '" target="_blank">
                                    <img src="' . $imgUrl . '" alt="' . e($row->name) . '" width="60" height="60" style="object-fit:cover;border-radius:6px;">
                                </a>';
                    }
                    return 'N/A';
                })
                
                ->addColumn('role', function ($row) {
                    return $row->roles->first()->name ?? 'N/A';
                })
 
                ->editColumn('status', function ($row) {
                    $badges = [
                        'Active' => 'bg-success',
                        'Inactive' => 'bg-warning',
                        'Blocked' => 'bg-danger'
                    ];
                    $badgeClass = $badges[$row->status] ?? 'bg-secondary';
                    return '<span class="badge ' . $badgeClass . '">' . $row->status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.users.add', $row->id);
                    $btn = '';
                    if(auth()->user()->can('user-add')) {
                        $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a> ';
                    }
                    if(auth()->user()->can('user-delete')) {
                        $btn .= '<a title="Delete Record" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['profile_pic', 'status', 'action'])
                ->make(true);
        }
    }



    public function delete(Request $request)
    {

     if (!auth()->user()->can('user-delete')) {
        return response()->json([ 
            'status' => false,
            'message' => 'Permission denied'
        ], 403);
    }

        $id = $request->get('id');
        $user = User::find($id);

        if($user){
            $user->delete();
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



    public function changeStatus(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->status = $request->status;
            $user->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully.']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}
