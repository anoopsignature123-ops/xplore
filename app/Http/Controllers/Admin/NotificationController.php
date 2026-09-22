<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Notification;
use App\Models\WebSettings;
use Illuminate\Support\Facades\Validator;
use App\Services\FirebaseService;


class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }


    public function index()
    {
        $page_title = 'Notification List';
        return view('admin.notification.list', compact('page_title'));
    }

    public function add($id = null)
    {
        $notification = !empty($id) ? Notification::find($id) : null;

        if ($id && !$notification) {
            return redirect()->route('admin.notification.list')->with('error', 'Record Not Found');
        }

        $btn_title  = $notification ? 'Update' : 'Submit';
        $page_title = $notification ? 'Update Notification' : 'Add Notification';

        return view('admin.notification.add', compact('notification', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $id = $request->id;

        $rules = [
            'title'        => 'required|string|max:255',
            'short_detail' => 'required|string',
            'status'       => 'required|in:Active,Inactive',
            'image'        => $id ? 'nullable|image|mimes:jpg,jpeg,png|max:2048' : 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $notification = $id ? Notification::find($id) : new Notification();

        if ($id && !$notification) {
            return response()->json(['message' => 'Record Not Found'], 404);
        }

        $notification->title        = trim($request->title);
        $notification->short_detail = trim($request->short_detail);
        $notification->status       = $request->status;

        // image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploaded = uploadImage($file, 'notification', $notification->image ?? '');
            $notification->image = $uploaded['image'] ?? null;
        }

        $notification->save();

        // Send Push Notification if it's a new notification
        if (!$id) {
            $tokens = \App\Models\Customer::where('status', 'Active')
                ->whereNotNull('fcm_token')
                ->where('fcm_token', '!=', '')
                ->whereNotNull('device_id')
                ->where('device_id', '!=', '')
                ->pluck('fcm_token')
                ->toArray();

            if (!empty($tokens)) {
                try {

                    $settings = WebSettings::select('logo')->first();
                    
                    $imageUrl = $notification->image ? asset($notification->image)  : (($settings && $settings->logo) ? asset($settings->logo) : null);
                    
                    
                    // Firebase Multicast limits to 100 tokens per request
                    $tokenChunks = array_chunk($tokens, 100); 
                      
                    foreach ($tokenChunks as $chunk) {
                        $this->firebaseService->sendNotificationToMultiple( 
                            $chunk,
                            $notification->title,
                            $notification->short_detail,
                            $imageUrl,
                            ['type' => 'general_notification', 'id' => (string)$notification->id]
                        );
                    }
                } catch (\Exception $e) {
                    \Log::error('Firebase Notification Error: ' . $e->getMessage());
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => $id ? 'Notification updated successfully.' : 'Notification added successfully.'
        ]);
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {

            $query = Notification::select(['id', 'title','image', 'status','created_at'])->orderBy('id', 'desc');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()

                ->editColumn('image', function ($row) {
                    if (!empty($row->image)) {
                        $imgUrl = asset($row->image);
                        return '<a href="' . $imgUrl . '" target="_blank">
                                    <img src="' . $imgUrl . '" width="60" height="60" style="object-fit:cover;border-radius:6px;">
                                </a>';
                    }
                    return 'N/A';
                })

                            
                ->editColumn('created_at', function ($row) {
                    $date = \Carbon\Carbon::parse($row->created_at);
                    $formatted = $date->format('d-m-Y h:i A');

                    $badge = '';
                    if ($date->diffInDays(now()) >= 7) {
                        $badge = ' <span class="badge bg-warning text-dark ms-1">1 week old</span>';
                    }

                    return $formatted . $badge;
                })

                ->editColumn('status', function ($row) {

                    if (!auth()->user()->can('notification-add')) {
                        return '<span class="badge bg-' . ($row->status === 'Active' ? 'success' : 'danger') . '">' . $row->status . '</span>';
                    }

                    $checked = $row->status === 'Active' ? 'checked' : '';

                    return '
                        <label class="switch mb-0">
                            <input type="checkbox" class="toggleStatus" data-id="' . $row->id . '" ' . $checked . '>
                            <span class="switch-state"></span>
                        </label>
                    ';
                })

                ->addColumn('action', function ($row) {

                    $editUrl = route('admin.notification.add', $row->id);
                    $btn = '';
                    if (auth()->user()->can('notification-add')) {
                        $btn .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('notification-delete')) {
                        $btn .= '<a href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash"></i></a>';
                    }

                    return $btn;
                })

                ->rawColumns(['image','created_at', 'status', 'action'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        if (!auth()->user()->can('notification-delete')) {
            return response()->json([
                'status' => false,
                'message' => 'Permission denied'
            ], 403);
        }

        $notification = Notification::find($request->id);
        if ($notification) {
            deleteFile($notification->image);
            $notification->delete();
            return response()->json([
                'status' => true,
                'message' => 'Record deleted successfully'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Record not found'
        ]);
    }


    public function changeStatus(Request $request)
    {
        $notification = Notification::find($request->id);
        if ($notification) {
            $notification->status = $request->status;
            $notification->save();
            return response()->json(['status' => true,'message' => 'Status updated successfully']);
        }
        return response()->json(['status' => false,'message' => 'Record not found']);
    }
}