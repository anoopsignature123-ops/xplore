<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::with('causer')->latest();

            if ($request->has('user_id') && $request->user_id != '') {
                $data->where('causer_id', $request->user_id)->where('causer_type', User::class);
            }
            if ($request->has('role') && $request->role != '') {
                $data->whereHasMorph('causer', [User::class], function($q) use ($request) {
                    $q->whereHas('roles', function($q2) use ($request) {
                        $q2->where('name', $request->role);
                    });
                });
            }
            if ($request->has('from_date') && $request->from_date != '') {
                $data->whereDate('created_at', '>=', $request->from_date);
            }
            if ($request->has('to_date') && $request->to_date != '') {
                $data->whereDate('created_at', '<=', $request->to_date);
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function($row){
                    if ($row->causer && method_exists($row->causer, 'roles') && $row->causer->roles->count() > 0) {
                        return '<span class="badge bg-primary">' . htmlspecialchars($row->causer->roles->first()->name) . '</span>';
                    }
                    if (!$row->causer) {
                        return '<span class="badge bg-secondary">System</span>';
                    }
                    return '-';
                })
                ->addColumn('user', function($row){
                    if ($row->causer) {
                        return htmlspecialchars($row->causer->name) . ' | ' . htmlspecialchars($row->causer->email);
                    }
                    return 'System';
                })
                ->addColumn('description', function($row){
                    return $row->description;
                })
                ->addColumn('subject', function($row){
                    return $row->subject_type ? class_basename($row->subject_type) . ' (ID: ' . $row->subject_id . ')' : '-';
                })
                ->addColumn('created_at', function($row){
                    return $row->created_at->format('d M Y h:i A'); // 09 Jun 2026 09:13 AM
                })
                ->addColumn('action', function($row){
                    if($row->properties && $row->properties->count() > 0) {
                        $props = $row->properties->toArray();
                        
                        // Format dates in old and attributes (new) arrays
                        foreach(['attributes', 'old'] as $key) {
                            if(isset($props[$key])) {
                                if(isset($props[$key]['created_at'])) {
                                    $props[$key]['created_at'] = \Carbon\Carbon::parse($props[$key]['created_at'])->setTimezone(config('app.timezone'))->format('d M Y h:i A');
                                }
                                if(isset($props[$key]['updated_at'])) {
                                    $props[$key]['updated_at'] = \Carbon\Carbon::parse($props[$key]['updated_at'])->setTimezone(config('app.timezone'))->format('d M Y h:i A');
                                }
                                if(isset($props[$key]['email_verified_at']) && $props[$key]['email_verified_at'] != null) {
                                    $props[$key]['email_verified_at'] = \Carbon\Carbon::parse($props[$key]['email_verified_at'])->setTimezone(config('app.timezone'))->format('d M Y h:i A');
                                }
                                if(isset($props[$key]['deleted_at']) && $props[$key]['deleted_at'] != null) {
                                    $props[$key]['deleted_at'] = \Carbon\Carbon::parse($props[$key]['deleted_at'])->setTimezone(config('app.timezone'))->format('d M Y h:i A');
                                }
                                if(isset($props[$key]['assigned_at']) && $props[$key]['assigned_at'] != null) {
                                    $props[$key]['assigned_at'] = \Carbon\Carbon::parse($props[$key]['assigned_at'])->setTimezone(config('app.timezone'))->format('d M Y h:i A');
                                }
                            }
                        }

                        return '<button type="button" class="btn btn-sm btn-info view-properties" data-properties=\''.htmlspecialchars(json_encode($props), ENT_QUOTES, 'UTF-8').'\'><i class="fas fa-eye"></i> View</button>';
                    }
                    return '-';
                })
                ->rawColumns(['role', 'user', 'description', 'subject', 'created_at', 'action'])
                ->make(true);
        }
        
        $users = User::select('id', 'name', 'email')->get();
        $roles = Role::select('id', 'name')->get();

        return view('admin.activity_log.index', compact('users', 'roles'));
    }

    public function clear(Request $request)
    {
        Activity::truncate();
        return response()->json(['status' => true, 'message' => 'Activity logs cleared successfully.']);
    }
}