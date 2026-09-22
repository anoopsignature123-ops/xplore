<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Yajra\DataTables\DataTables;
use App\Models\CourseLesson;
use App\Models\CourseTopic; 
use App\Models\Content; 
 
use Illuminate\Support\Facades\Validator; 

class CourseTopicController extends Controller {
 
 public function index($lesson_id)
{ 
    $page_title = 'Course Topic List';
    $lesson_record = CourseLesson::with('course:id,course_name')->find($lesson_id);
    if (!$lesson_record) {
        return redirect()->route('admin.course-lesson.list')->with('error', 'Course Lesson Not exists');
    } 
    return view('admin.course-topic.list', compact('page_title','lesson_record', 'lesson_id'));
}

public function add($lesson_id = null, $id = null)
{ 
    $course_topic = !empty($id) ? CourseTopic::find($id) : null;
    if ($id && !$course_topic) {
        return redirect()->route('admin.course-topic.list', $lesson_id)->with('error', 'Record Not Found');
    }

    $lesson_record = CourseLesson::with('course:id,course_name')->find($lesson_id);
    if (!$lesson_record) {
        return redirect()->route('admin.course-lesson.list')->with('error', 'Course Lesson Not exists');
    } 
    $btn_title  = $course_topic ? 'Update' : 'Submit';
    $page_title = $course_topic ? 'Update Course Topic' : 'Add Course Topic';
    return view('admin.course-topic.add', compact('course_topic','lesson_record', 'btn_title', 'page_title', 'lesson_id'));
}
   

  


public function save(Request $request)
{
    $id = $request->id;
    $rules = [
        'lesson_id'  => 'required|exists:course_lessons,id',
        'topic_name' => 'required|string|max:255',
        'priority'   => 'nullable|integer',
        'status'     => 'required|in:Active,Inactive',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $exists = CourseTopic::where('lesson_id', $request->lesson_id)->where('topic_name', trim($request->topic_name));

    if ($id) {
        $exists->where('id', '!=', $id);
    }

    if ($exists->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'Topic already exists'
        ], 422);
    }

    $content = $id ? CourseTopic::findOrFail($id) : new CourseTopic();
    $content->lesson_id  = $request->lesson_id;
    $content->topic_name = trim($request->topic_name);
    $content->priority   = $request->priority;
    $content->status     = $request->status;

    $content->save();

    return response()->json([
        'success' => true,
        'message' => $id ? 'Topic Updated Successfully' : 'Topic Added Successfully'
    ]);
}



   
public function getRecords(Request $request) 
{
    if ($request->ajax()) {

        $query = CourseTopic::with('lesson:id,lesson_name')
            ->select(['id', 'lesson_id', 'topic_name', 'priority', 'status', 'created_at']);

             if ($request->filled('lesson_id')) {
                $query->where('lesson_id', $request->lesson_id);
            }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $query->orderBy('id', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()

            // LESSON NAME COLUMN
            ->addColumn('lesson_name', function ($row) {
                return $row->lesson->lesson_name ?? 'N/A';
            }) 

            // TOPIC NAME
            ->editColumn('topic_name', function ($row) {
                return $row->topic_name;
            })

            // STATUS
            ->editColumn('status', function ($row) {
                if (!auth()->user()->can('course-topic-add')) {
                    return '<span class="badge bg-' . ($row->status === 'Active' ? 'success' : 'danger') . '">' . $row->status . '</span>';
                }

                $checked = $row->status === 'Active' ? 'checked' : '';
                $statusClass = $row->status === 'Active' ? 'bg-success' : 'bg-danger';

                return '
                    <label class="switch mb-0">
                        <input type="checkbox" class="toggleStatus" data-id="' . $row->id . '" ' . $checked . '>
                        <span class="switch-state ' . $statusClass . '"></span>
                    </label>
                ';
            })

            // ACTION
            ->addColumn('action', function ($row) {
                 $editUrl = route('admin.course-topic.add', ['lesson_id' => $row->lesson_id, 'id' => $row->id]);

                $btn = '';

                 if (auth()->user()->can('course-content-list')) {
                    $topicUrl = route('admin.course-content.list', ['topic_id' => $row->id]);
                    $btn .= '<a href="' . $topicUrl . '" class="btn btn-sm btn-info m-1" title="View Topics"><i class="fas fa-list-ul"></i> Content</a>';
                }

                if (auth()->user()->can('course-topic-add')) {
                    $btn .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary m-1">
                                <i class="fas fa-edit"></i>
                             </a>';
                }

                if (auth()->user()->can('course-topic-delete')) {
                    $btn .= '<a href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" 
                                class="btn btn-sm btn-danger m-1">
                                <i class="fas fa-trash-alt"></i>
                             </a>';
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
        $course_topic = CourseTopic::find($id); 

        if($course_topic){ 
            $course_topic->delete();
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
        $course_topic = CourseTopic::find($request->id);
        if ($course_topic) {
            $course_topic->status = $request->status;
            $course_topic->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}
