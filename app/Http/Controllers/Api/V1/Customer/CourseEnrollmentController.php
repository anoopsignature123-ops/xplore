<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; 

class CourseEnrollmentController extends Controller
{
   

   public function enroll(Request $request)
{
    $request->validate([
        'customer_id' => 'required|string',
        'course_id' => 'required|string', 
    ]);

    // Check if already enrolled
    $alreadyEnrolled = CourseEnrollment::where('customer_id', $request->customer_id)->where('course_id', $request->course_id)->exists();

    if ($alreadyEnrolled) {
        return response()->json([
            'status' => false,
            'message' => 'You are already enrolled in this course.'
        ], 400);
    }

    // Check if course exists
    $course = Course::with('category')->find($request->course_id);

    if (!$course) {
        return response()->json([
            'status' => false,
            'message' => 'Course not found.'
        ], 404);
    }

    // Create enrollment
    $enrollment = CourseEnrollment::create([
        'customer_id' => $request->customer_id,
        'course_id' => $course->id,
        'course_name' => $course->course_name,
        'course_category_name' => $course->category ? $course->category->name : '',
        'duration' => $course->duration,
        'amount' => $course->amount,
        'payment_status' => 'pending',
        'status' => 'pending',
    ]);

    if ($enrollment) {
        return response()->json([
            'status' => true,
            'message' => 'Successfully enrolled in course, transaction pending.',
            'enrollment_id' => $enrollment->id 
        ], 201);
    } else {
        return response()->json([
            'status' => false,
            'message' => 'Failed to enroll in course.'
        ], 500);
    }
}


}
