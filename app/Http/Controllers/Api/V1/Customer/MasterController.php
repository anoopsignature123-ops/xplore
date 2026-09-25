<?php

namespace App\Http\Controllers\Api\V1\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\State;
use App\Models\Slider;
use App\Models\Survey;
use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseContent;
use App\Models\CourseTopic;
use App\Models\Faq;
use App\Models\HelpQuestion; 
use App\Models\HelpQuery;
use App\Models\CourseEnrollment;
use App\Models\Cms;


class MasterController extends Controller
{
    public function surveyList(Request $request)
    {
         
        $validator = Validator::make($request->all(), [
            'page_no'          => 'nullable|string|min:1', 
            'per_page_record'  => 'nullable|string|min:1', 
        ]); 

        if ($validator->fails()) { 
            return response()->json([ 
                'status'  => false, 
                'message' => $validator->errors()->first(),
            ], 422);
        }
 
        $perPage     = $request->per_page_record ?? 10;
        $page        = $request->page_no ?? 1;
 
        $query = Survey::select('id', 'name','short_detail','amount','image')->where('status', 'Active')->orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page); 
    
        $data = collect($query->items())->map(function ($record) { 
            $record->image_url = !empty($record->image)? asset($record->image): null;
            return $record;
        });
 

        return response()->json([ 
            'status' => true, 
            'message' => 'Survey List fetched successfully',
            'data' => $data,   
        ]);
    } 


    public function courseCategoryList(Request $request)
{  
    $validator = Validator::make($request->all(), [
        'page_no' => 'nullable|string|min:1',
        'per_page_record' => 'nullable|string|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $page = $request->page_no ?? 1;
    $perPage = $request->per_page_record ?? 10;
    $query = CourseCategory::select('id', 'name')->where('status', 'Active')->orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page); 
  

    return response()->json([
        'status' => true,
        'message' => 'Course Category List fetched successfully',
        'data' => $query->items(),
    ]);
} 


public function courseList(Request $request)
{
    $validator = Validator::make($request->all(), [
        'course_category_id' => 'nullable|exists:course_categories,id',
        'page_no'            => 'nullable|string|min:1', 
        'per_page_record'    => 'nullable|string|min:1', 
    ]);
  
    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $page = $request->page_no ?? 1;
    $perPage = $request->per_page_record ?? 10; 
    $query = Course::select('id','course_category_id','course_name','image','short_detail','duration','amount')->where('status', 'Active');

    if (!empty($request->course_category_id)) {
        $query->where('course_category_id', $request->course_category_id);
    }

    $query = $query->orderBy('course_name', 'asc')->paginate($perPage, ['*'], 'page', $page);

      $data = collect($query->items())->map(function ($record) {
            $record->image = !empty($record->image)? asset($record->image): null;
            return $record; 
        });
        

    return response()->json([ 
        'status'  => true,
        'message' => 'Course List fetched successfully',
        'data'    => $data, 
    ]); 
} 



public function courseLessonList(Request $request)
{
    $validator = Validator::make($request->all(), [
        'customer_id'        => 'nullable|exists:customers,id',  
        'course_id'        => 'required|exists:courses,id',
        'page_no'          => 'nullable|string|min:1',
        'per_page_record'  => 'nullable|string|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $page = $request->page_no ?? 1;
    $perPage = $request->per_page_record ?? 10;

    $query = CourseLesson::select( 'id','course_id','lesson_name','mode')
        ->where('course_id', $request->course_id)
        ->where('status', 'Active')
        ->orderBy('priority', 'asc')
        ->paginate($perPage, ['*'], 'page', $page);

    $is_enrolled = false;
    if (!empty($request->customer_id)) {
        $enrollment = CourseEnrollment::where('customer_id', $request->customer_id)
            ->where('course_id', $request->course_id)
            ->first();
        if ($enrollment) {
            $is_enrolled = true;
        } 
    }

    return response()->json([
        'status'      => true,
        'message'     => 'Course Lesson List fetched successfully',
        'is_enrolled' => $is_enrolled,
        'data'        => $query->items(),
    ]);
}


public function courseTopicList(Request $request)
{
    $validator = Validator::make($request->all(), [
        'lesson_id' => 'required|exists:course_lessons,id',
        'page_no'          => 'nullable|string|min:1',
        'per_page_record'  => 'nullable|string|min:1',
    ]);
 
    if ($validator->fails()) { 
        return response()->json([
            'status'  => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $page = $request->page_no ?? 1;
    $perPage = $request->per_page_record ?? 10;

    $query = CourseTopic::select('id','lesson_id','topic_name')
    ->where('lesson_id', $request->lesson_id)->where('status', 'Active')
    ->orderBy('priority', 'asc')->paginate($perPage, ['*'], 'page', $page);

    return response()->json([
        'status'  => true,
        'message' => 'Course Topic List fetched successfully',
        'data'    => $query->items(),
    ]);
}



public function courseContentList(Request $request)
{
    $validator = Validator::make($request->all(), [
        'topic_id' => 'required|exists:course_topics,id',
    ]); 

    if ($validator->fails()) { 
        return response()->json([ 
            'status'  => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $contents = CourseContent::select('id','topic_id','type','name','pdf','video_id')->where('status', 'Active')->where('topic_id', $request->topic_id)->orderBy('priority', 'asc')->get();

    $pdfContent = $contents->where('type', 'PDF')->map(function ($record) {
        return [
            'topic_id' => $record->topic_id,
            'name'     => $record->name, 
            'pdf'      => !empty($record->pdf) ? asset($record->pdf) : null,
        ]; 
    })->values();

    $videoContent = $contents->where('type', 'Video')->map(function ($record) {
        return [
            'topic_id' => $record->topic_id,
            'name'     => $record->name,
            'video_id' => $record->video_id,
        ];
    })->values();

    return response()->json([
        'status'  => true,
        'message' => 'Course Content List fetched successfully',
        'pdf_content'   => $pdfContent,
        'video_content' => $videoContent,
    ]);
}


public function faqList(Request $request)
{
    $validator = Validator::make($request->all(), [
        'page_no'          => 'nullable|string|min:1',
        'per_page_record'  => 'nullable|string|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => $validator->errors()->first(),
        ], 422); 
    }

    $page = $request->page_no ?? 1;
    $perPage = $request->per_page_record ?? 10;

    $query = Faq::select('question','answer')
        ->where('status', 'Active')
        ->orderBy('priority', 'asc')
        ->paginate($perPage, ['*'], 'page', $page);

    return response()->json([
        'status'  => true,
        'message' => 'Faq List fetched successfully', 
        'data'    => $query->items(),
    ]);
}


    public function sliderList(Request $request)
    {
        $rules = [
          'type' => 'required|string|in:home,survey,build,mart,academy,equipment',
        ];
 
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $type  = trim($request->type);

        $sliders = Slider::select('name','image')->where('type',$type)->where('status', 'Active')->orderByDesc('id')->get()
            ->map(function ($slider) {
                return [
                    'name' => $slider->name ?? '',
                    'image' => !empty($slider->image) ? asset($slider->image) : '',
                ];
            });

        return response()->json([
            'status'  => true,
            'message' => 'Slider List fetched successfully',
            'data'    => $sliders
        ], 200);
    }


    public function getHelpQuestion(Request $request) 
    {
        $questions = HelpQuestion::select('id', 'question')
            ->where('status', 'Active')
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Help questions fetched successfully',
            'data'    => $questions
        ], 200);
    }
 
    public function submitHelpQuery(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer', 
            'question_id' => 'required|exists:help_questions,id',
            'message'    => 'nullable|string|max:250', 
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $helpQuestion = HelpQuestion::find($request->question_id);
 
        $query = HelpQuery::create([
            'customer_id' => $request->customer_id,
            'question'    => $helpQuestion->question, 
            'message'    => $request->message,  
            'remark'      => null,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Help query submitted successfully', 
        ], 200);
    }

    public function getCms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pagename' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $cms = Cms::select('heading', 'description', 'pagename')
            ->where('pagename', $request->pagename)
            ->where('status', 'Active')
            ->first();

        if (!$cms) {
            return response()->json([
                'status'  => false,
                'message' => 'Page not found or inactive',
            ], 404);
        }

        $cms->web_view_url = url('/page/' . str_replace('_', '-', $cms->pagename));

        return response()->json([
            'status'  => true,
            'message' => 'CMS fetched successfully',
            'data'    => $cms
        ], 200);
    }
}
