<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Yajra\DataTables\DataTables;
use App\Models\CourseCategory;

use Illuminate\Support\Facades\Validator;

class CourseCategoryController extends Controller {

    public function index() {
         $page_title = 'Course Category List';
         return view('admin.course-category.list', compact('page_title'));
    }
    

    public function add($id = null) {
        $course_category = !empty($id) ? CourseCategory::find($id) : null;
        if ($id && !$course_category) { 
            return redirect()->route('admin.course-category.list')->with('error', 'Record Not Found');
        } 
        $btn_title  = $course_category ? 'Update' : 'Submit'; 
        $page_title = $course_category ? 'Update Course Category' : 'Add Course Category';
        return view('admin.course-category.add', compact('course_category', 'btn_title', 'page_title'));
    }


  
    public function save(Request $request)
{
    $input = $request->all();
    $id = $input['id'] ?? null;

    $rules = [
        'name' => 'required|string|max:255', 
        'status' => 'required|in:Active,Inactive',
    ];

    $validator = Validator::make($input, $rules);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $exists = CourseCategory::where('name', $input['name']);
if (!empty($id)) {
    $exists->where('id', '!=', $id);
}

if ($exists->exists()) {
    return response()->json([
        'success' => false,
        'message' => 'Category already exists'
    ], 422);
}


    // find or create 
    $course_category = CourseCategory::find($id);

    if ($id && !$course_category) {
        return response()->json([
            'message' => 'Record Not Found'
        ], 404);
    }

    if (!$course_category) {
        $course_category = new CourseCategory(); 
    }


    // assign fields
    $course_category->name = trim($input['name']);
    $course_category->status = $input['status'];
    $course_category->save();

    return response()->json([
        'success' => true, 'message' => $id ? 'Record Updated Successfully' : 'Record Added Successfully'
    ]); 
}



    public function getRecords(Request $request) 
    {
        if ($request->ajax()) {     
             $query = CourseCategory::select(['id', 'name', 'status']);
      

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $query->orderBy('id', 'desc');

            return DataTables::of($query) 
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    if (!empty($row->image)) {
                        $imgUrl = asset($row->image);
                        return '<a href="' . $imgUrl . '" target="_blank">
                                    <img src="' . $imgUrl . '" alt="' . e($row->name) . '" width="60" height="60" style="object-fit:cover;border-radius:6px;">
                                </a>';
                    }
                    return 'N/A';
                })
                
              
                 ->editColumn('status', function ($row) {
                    if (!auth()->user()->can('course-category-add')) {
                        return '<span class="badge bg-' . ($row->status === 'Active' ? 'success' : 'danger') . '">' . $row->status . '</span>';
                    }

                    $checked = $row->status === 'Active' ? 'checked' : '';
                    $statusClass = $row->status === 'Active' ? 'bg-success' : 'bg-danger';

                    return '
                        <div class="d-flex align-items-center">
                            <div class="icon-state">
                                <label class="switch mb-0">
                                    <input type="checkbox" class="toggleStatus" data-id="' . $row->id . '" ' . $checked . '>
                                    <span class="switch-state ' . $statusClass . '"></span>
                                </label>
                            </div>
                        </div>
                    ';
                })

 
                    ->addColumn('action', function ($row) {
                        $editUrl = route('admin.course-category.add', $row->id);
                        $btn = ''; 
                        if(auth()->user()->can('course-category-add')) {
                            $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a> ';
                        } 
                        if(auth()->user()->can('course-category-delete')) {
                            $btn .= '<a title="Delete Record" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i></a>';
                        }
                        return $btn;
                    }) 
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
    }
 


    public function delete(Request $request)
    {
        $id = $request->get('id');
        $course_category = CourseCategory::find($id);

        if($course_category){
            $course_category->delete();
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
        $course_category = CourseCategory::find($request->id);
        if ($course_category) {
            $course_category->status = $request->status;
            $course_category->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}
