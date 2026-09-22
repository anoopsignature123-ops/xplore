<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Yajra\DataTables\DataTables;
use App\Models\CourseContent;
use App\Models\CourseTopic; 
use App\Models\CourseLesson; 
use Illuminate\Support\Facades\Validator; 
use Illuminate\Validation\Rule; 

class CourseContentController extends Controller {
 
    public function index($topic_id)
    {
        $page_title = 'Course Content List';
        $topic_record = CourseTopic::with('lesson.course:id,course_name')->find($topic_id);
        if (!$topic_record) {
            return redirect()->route('admin.course-topic.list', $topic_record->lesson_id)->with('error', 'Course Topic Not exists');
        } 
        return view('admin.course-content.list', compact('page_title', 'topic_record', 'topic_id'));
    }

    public function add($topic_id = null, $id = null) 
    {
        $course_content = !empty($id) ? CourseContent::find($id) : null;

        if ($id && !$course_content) {
            return redirect()->route('admin.course-content.list', $topic_id)->with('error', 'Record Not Found');
        }

        $topic_record = CourseTopic::with('lesson.course:id,course_name')->find($topic_id);

        if (!$topic_record) {
            return redirect()->route('admin.course-topic.list')->with('error', 'Course Topic Not exists');
        }

        $btn_title  = $course_content ? 'Update' : 'Submit';
        $page_title = $course_content ? 'Update Course Content' : 'Add Course Content';
        return view('admin.course-content.add', compact('course_content','topic_record','btn_title','page_title','topic_id'));
    }

    public function save(Request $request)
    {
        $id = $request->id;
        $rules = [
            'topic_id'  => 'required|exists:course_topics,id',
            'type'      => ['required', Rule::in(['PDF', 'Video'])],
            'name'      => 'required|string|max:255',
            'priority'  => 'nullable|integer',
            'status' => 'required|in:Active,Inactive',
        ];
 
        if ($request->type === 'PDF') {
            $rules['pdf'] = $id  ? 'nullable|file|mimes:pdf' : 'required|file|mimes:pdf';
            $rules['video_id'] = 'nullable|string';
        }

        if ($request->type === 'Video') { 
            $rules['video_id'] = $id  ? 'nullable|string' : 'required|string';
            $rules['pdf'] = 'nullable|file|mimes:pdf';
        }

 
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) { 
            return response()->json([
                'errors' => $validator->errors() 
            ], 422);
        }

        $exists = CourseContent::where('topic_id', $request->topic_id)->where('name', trim($request->name));

        if ($id) {
            $exists->where('id', '!=', $id);
        }

        if ($exists->exists()) {
            return response()->json(['success' => false,'message' => 'Content already exists'], 422);
        }

        $content = $id ? CourseContent::findOrFail($id) : new CourseContent();
        $content->topic_id  = $request->topic_id;
        $content->type      = $request->type;
        $content->name      = trim($request->name);
        $content->priority  = $request->priority;
        $content->video_id = $request->video_id;
        $content->status = $request->status; 
 
        // Handle PDF upload
         if ($request->hasFile('pdf')) {
            $fileName = $request->file('pdf'); 
            $uploaded = uploadImage($fileName,'course-content',$request->input('pdf'));
            $content->pdf = $uploaded['image'] ?? '';
        }

        $content->save();

        return response()->json([
            'success' => true,
            'message' => $id ? 'Content Updated Successfully' : 'Content Added Successfully'
        ]);
    }

    public function getRecords(Request $request) 
    {
        if ($request->ajax()) {

            $query = CourseContent::with('topic:id,topic_name')->select(['id', 'topic_id', 'type', 'name', 'pdf', 'video_id', 'priority','status', 'created_at']);

            if ($request->filled('topic_id')) {
                $query->where('topic_id', $request->topic_id); 
            }

            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            $query->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()

                // TOPIC NAME COLUMN
                ->addColumn('topic_name', function ($row) {
                    return $row->topic->topic_name ?? 'N/A';
                }) 

                // CONTENT NAME
                ->editColumn('name', function ($row) {
                    return $row->name;
                })

                // TYPE
                ->editColumn('type', function ($row) {
                    $color = $row->type === 'PDF' ? 'primary' : 'info';
                    return '<span class="badge bg-' . $color . '">' . strtoupper($row->type) . '</span>';
                })

 
                // PDF / VIDEO LINK
                ->addColumn('content_link', function ($row) {
                    if ($row->type === 'PDF' && $row->pdf) {
                        return '<a href="' . asset($row->pdf) . '" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-file-pdf"></i> View PDF</a>';
                    } 
                    elseif ($row->type === 'Video' && $row->video_id) {
                        $youtubeUrl = 'https://www.youtube.com/watch?v=' . $row->video_id;
                        return '<a href="' . $youtubeUrl . '" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-play-circle"></i> Watch Video</a>';
                    } 

                    return 'N/A';
                })


                 
                 ->editColumn('status', function ($row) {
                    if (!auth()->user()->can('course-content-add')) {
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
 


                // ACTION
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.course-content.add', ['topic_id' => $row->topic_id, 'id' => $row->id]);

                    $btn = '';
                    if (auth()->user()->can('course-content-add')) {
                        $btn .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary m-1">
                                    <i class="fas fa-edit"></i>
                                 </a>';
                    }

                    if (auth()->user()->can('course-content-delete')) {
                        $btn .= '<a href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" 
                                    class="btn btn-sm btn-danger m-1">
                                    <i class="fas fa-trash-alt"></i>
                                 </a>';
                    }

                    return $btn;
                })

                ->rawColumns(['type', 'content_link', 'status','action'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        $course_content = CourseContent::find($id); 
        if ($course_content) {
            $course_content->delete();
            return response()->json(['status' => true,'message' => 'Record Deleted successfully']);
        }
        return response()->json(['status' => false,'message' => 'Record Not Found']); 
    }

      public function changeStatus(Request $request)
    {
        $course_content = CourseContent::find($request->id);
        if ($course_content) {
            $course_content->status = $request->status;
            $course_content->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }

}