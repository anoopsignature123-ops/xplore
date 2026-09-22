<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Yajra\DataTables\DataTables;
use App\Models\Course;
use App\Models\CourseLesson; 
 
use Illuminate\Support\Facades\Validator;

class CourseLessonController extends Controller {

    public function index() {
         $page_title = 'Course Lesson List';
         return view('admin.course-lesson.list', compact('page_title'));
    }

 
public function add($id = null)
{
    $course_lesson = !empty($id)? CourseLesson::find($id): null;
    if ($id && !$course_lesson) {
        return redirect()->route('admin.course-lesson.list')->with('error', 'Record Not Found');
    }
    $course_list = Course::select('id', 'course_name')->get();
    $btn_title  = $course_lesson ? 'Update' : 'Submit';
    $page_title = $course_lesson ? 'Update Lesson' : 'Add Lesson';
    return view('admin.course-lesson.add',compact('course_lesson','course_list','btn_title','page_title'));
} 
   


public function save(Request $request)
{
    $id = $request->id;
 
    $rules = [
        'course_id'   => 'required|exists:courses,id',
        'lesson_name' => 'required|string|max:255',
        'priority' => 'required|string', 
        'mode'        => 'required|in:Free,Paid', 
        'status'      => 'required|in:Active,Inactive',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $exists = CourseLesson::where('lesson_name', $request->lesson_name)->where('course_id', $request->course_id);

    if ($id) {
        $exists->where('id', '!=', $id);
    }

    if ($exists->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'Lesson already exists'
        ], 422);
    }

    $course_lesson = $id? CourseLesson::find($id): new CourseLesson();
    $course_lesson->course_id = $request->course_id;
    $course_lesson->lesson_name = trim($request->lesson_name);
    $course_lesson->priority = trim($request->priority);
    $course_lesson->mode = $request->mode;
    $course_lesson->status = $request->status;
    $course_lesson->save();
    return response()->json([
        'success' => true,
        'message' => $id ? 'Lesson Updated Successfully' : 'Lesson Added Successfully'
    ]);
}



public function getRecords(Request $request)
{
    if ($request->ajax()) {

        $query = CourseLesson::with('course:id,course_name')->select(['id','course_id','lesson_name','priority','mode','status']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('course', function ($row) {
                return $row->course->course_name ?? 'N/A'; 
            })

            ->editColumn('mode', function ($row) {
                return $row->mode;
            })

            ->editColumn('status', function ($row) {
                $checked = $row->status == 'Active'? 'checked': '';
                return '
                    <label class="switch"><input type="checkbox"class="toggleStatus"data-id="'.$row->id.'"'.$checked.'><span class="switch-state"></span></label>';
            })

            ->addColumn('action', function ($row) {
                $btn = '';
                if (auth()->user()->can('course-topic-list')) {
                    $topicUrl = route('admin.course-topic.list', ['lesson_id' => $row->id]);
                    $btn .= '<a href="' . $topicUrl . '" class="btn btn-sm btn-info m-1" title="View Topics"><i class="fas fa-list-ul"></i> Topics</a>';
                }

                if (auth()->user()->can('course-lesson-add')) {
                    $btn .= '<a href="' .route('admin.course-lesson.add', $row->id) .'" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>';
                }
                if (auth()->user()->can('course-lesson-delete')) {
                    $btn .= '<a href="javascript:void(0)"onclick="deleteData('.$row->id.')"class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i></a>';
                }
                return $btn;
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}

 
 

    public function delete(Request $request)
    {
        $id = $request->get('id');
        $course_lesson = CourseLesson::find($id); 

        if($course_lesson){ 
            $course_lesson->delete();
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
        $course_lesson = CourseLesson::find($request->id);
        if ($course_lesson) {
            $course_lesson->status = $request->status;
            $course_lesson->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}
