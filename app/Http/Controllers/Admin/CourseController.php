<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Yajra\DataTables\DataTables;
use App\Models\Course;
use App\Models\CourseCategory; 
 
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller {

    public function index() {
         $page_title = 'Course List';
         return view('admin.course.list', compact('page_title'));
    }


 public function add($id = null)
{
    $course = !empty($id) ? Course::find($id) : null;

    if ($id && !$course) {
        return redirect()->route('admin.course.list')
            ->with('error', 'Record Not Found');
    }
 
    $course_category_list = CourseCategory::select('id', 'name')->get();
    $btn_title  = $course ? 'Update' : 'Submit';
    $page_title = $course ? 'Update Course' : 'Add Course';
    return view('admin.course.add', compact('course','course_category_list','btn_title','page_title'));
}

  

public function save(Request $request)
{
    $id = $request->id; 

    $rules = [
        'course_category_id' => 'required|exists:course_categories,id',
        'course_name' => 'required|string|max:255',
        'short_detail' => 'required|string',
        'duration' => 'required|string|max:255',
        'amount' => 'required|integer|min:0',
        'status' => 'required|in:Active,Inactive',
        'image' => $id ? 'nullable|image|mimes:jpg,jpeg,png|max:2048' : 'required|image|mimes:jpg,jpeg,png|max:2048',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) { 
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $exists = Course::where('course_name', $request->course_name);

    if ($id) {
        $exists->where('id', '!=', $id);
    }  

    if ($exists->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'Course already exists'
        ], 422);
    }

    $course = $id ? Course::find($id) : new Course();

    $course->course_category_id = $request->course_category_id;
    $course->course_name = trim($request->course_name);
    $course->short_detail = trim($request->short_detail);
    $course->duration = trim($request->duration);
    $course->amount = trim($request->amount); 
    $course->status = $request->status; 

    if ($request->hasFile('image')) {
        $uploaded = uploadImage($request->file('image'),'course',$course->image ?? '');
        $course->image = $uploaded['image'] ?? null;
    }

    $course->save();

    return response()->json([
        'success' => true,
        'message' => $id ? 'Course Updated Successfully' : 'Course Added Successfully'
    ]);
}


    public function getRecords(Request $request) 
    {
        if ($request->ajax()) {     
           $query = Course::with('category:id,name')->select(['id','course_category_id','course_name','amount','image','status']);
      
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

                 ->addColumn('category', function ($row) {
                return $row->category->name ?? 'N/A';
            })

                
               
                 ->editColumn('status', function ($row) {
                    if (!auth()->user()->can('course-add')) {
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
                        $editUrl = route('admin.course.add', $row->id);
                        $btn = ''; 
                        if(auth()->user()->can('course-add')) {
                            $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a> ';
                        } 
                        if(auth()->user()->can('course-delete')) {
                            $btn .= '<a title="Delete Record" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i></a>';
                        }
                        return $btn;
                    }) 
                ->rawColumns(['image','category', 'status', 'action'])
                ->make(true);
        }
    } 
 
 

    public function delete(Request $request)
    {
        $id = $request->get('id');
        $course = Course::find($id); 

        if($course){ 
            $course->delete();
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
        $course = Course::find($request->id);
        if ($course) {
            $course->status = $request->status;
            $course->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}
