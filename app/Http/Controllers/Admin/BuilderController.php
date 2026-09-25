<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Builder;
use App\Models\BuildCategory;
use App\Models\BuilderService;
use App\Models\BuilderCertification;
use App\Models\BuilderServiceArea;
use App\Models\BuilderCompletedProject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BuilderController extends Controller
{
    public function index()
    {
        $page_title = 'Builders & Contractors';
        $categories = BuildCategory::where('status', 1)->get();
        return view('admin.builder.list', compact('page_title', 'categories'));
    }

    public function getRecords(Request $request)
    {
        $query = Builder::with('category')->orderBy('id', 'desc');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('profile_image', function ($row) {
                if ($row->profile_image) {
                    $url = asset($row->profile_image);
                    return '<img src="' . $url . '" alt="' . e($row->name) . '" style="height: 45px; width: 45px; object-fit: cover; border-radius: 50%;">';
                }
                return '<span class="badge bg-light text-dark">No Image</span>';
            })
            ->editColumn('firm_name', function ($row) {
                $badge = $row->is_verified 
                    ? ' <i class="fas fa-check-circle text-primary" title="Verified"></i>' 
                    : '';
                return '<strong>' . e($row->firm_name) . '</strong>' . $badge . '<br><small class="text-muted">' . e($row->name) . '</small>';
            })
            ->editColumn('category', function ($row) {
                return $row->category ? '<span class="badge bg-secondary">' . e($row->category->name) . '</span>' : 'N/A';
            })
            ->editColumn('location', function ($row) {
                return '📍 ' . e($row->location ?? 'N/A');
            })
            ->editColumn('rating', function ($row) {
                return '⭐ ' . number_format($row->rating, 1);
            })
            ->editColumn('category', function ($row) {
                return $row->category ? '<span class="badge bg-soft-primary text-primary border border-primary"><i class="fas fa-tag me-1"></i>' . e($row->category->name) . '</span>' : 'N/A';
            })
            ->editColumn('rating', function ($row) {
                return '<span class="badge bg-warning text-dark"><i class="fas fa-star text-warning me-1"></i>' . number_format($row->rating, 1) . '</span>';
            })
            ->editColumn('is_verified', function ($row) {
                $checked = $row->is_verified ? 'checked' : '';
                $badge = $row->is_verified ? '<span class="badge bg-success ms-1"><i class="fas fa-check-circle"></i> Verified</span>' : '';
                return '<div class="d-flex align-items-center"><div class="form-check form-switch"><input class="form-check-input verify-toggle" type="checkbox" data-id="' . $row->id . '" ' . $checked . '></div>' . $badge . '</div>';
            })
            ->editColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '<div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.builder.add', $row->id);
                $deleteUrl = route('admin.builder.delete', $row->id);

                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1" title="Edit Builder"><i class="fas fa-edit me-1"></i> Edit</a>
                    <button data-url="' . $deleteUrl . '" class="btn btn-sm btn-danger delete-btn" title="Delete Builder"><i class="fas fa-trash-alt me-1"></i> Delete</button>
                ';
            })
            ->rawColumns(['profile_image', 'firm_name', 'category', 'rating', 'is_verified', 'status', 'action'])
            ->make(true);
    }

    public function add($id = null)
    {
        $builder = !empty($id) ? Builder::with(['services', 'certifications', 'serviceAreas', 'completedProjects', 'portfolios'])->find($id) : null;

        if ($id && !$builder) {
            return redirect()->route('admin.builder.list')->with('error', 'Builder Not Found');
        }

        $categories = BuildCategory::where('status', 1)->orderBy('name')->get();
        $btn_title  = $builder ? 'Update' : 'Submit';
        $page_title = $builder ? 'Update Builder Profile' : 'Add New Builder';

        return view('admin.builder.add', compact('builder', 'categories', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $id = $request->input('id');

        $rules = [
            'name'             => 'required|string|max:255',
            'firm_name'        => 'required|string|max:255',
            'category_id'      => 'required|exists:build_categories,id',
            'email'            => 'required|email|max:255|unique:builders,email,' . $id,
            'phone'            => 'required|string|max:20',
            'location'         => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'projects_count'   => 'required|integer|min:0',
            'rating'           => 'required|numeric|min:0|max:5',
            'status'           => 'required|boolean',
            'is_verified'      => 'nullable|boolean',
            'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'cover_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];

        if (!$id) {
            $rules['password'] = 'required|string|min:6';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'name'             => $request->name,
            'firm_name'        => $request->firm_name,
            'slug'             => Str::slug($request->firm_name) . ($id ? '' : '-' . time()),
            'category_id'      => $request->category_id,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'location'         => $request->location,
            'address'          => $request->address,
            'website'          => $request->website,
            'about'            => $request->about,
            'experience_years' => $request->experience_years,
            'projects_count'   => $request->projects_count,
            'rating'           => $request->rating,
            'is_verified'      => $request->has('is_verified') ? 1 : 0,
            'status'           => $request->status ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Profile image
        if ($request->hasFile('profile_image')) {
            $img = $request->file('profile_image');
            $fileName = 'profile_' . time() . '_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
            $path = 'uploads/builders/';
            $img->move(public_path($path), $fileName);
            $data['profile_image'] = $path . $fileName;
        }

        // Cover image
        if ($request->hasFile('cover_image')) {
            $img = $request->file('cover_image');
            $fileName = 'cover_' . time() . '_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
            $path = 'uploads/builders/';
            $img->move(public_path($path), $fileName);
            $data['cover_image'] = $path . $fileName;
        }

        if ($id) {
            $builder = Builder::findOrFail($id);
            $builder->update($data);
            $msg = 'Builder profile updated successfully!';
        } else {
            $builder = Builder::create($data);
            $msg = 'Builder profile created successfully!';
        }

        // Save Services
        if ($request->has('services')) {
            BuilderService::where('builder_id', $builder->id)->delete();
            $servicesList = is_array($request->services) ? $request->services : explode(',', $request->services);
            foreach ($servicesList as $sName) {
                if (!empty(trim($sName))) {
                    BuilderService::create([
                        'builder_id'   => $builder->id,
                        'service_name' => trim($sName),
                    ]);
                }
            }
        }

        // Save Certifications
        if ($request->has('certifications')) {
            BuilderCertification::where('builder_id', $builder->id)->delete();
            $certList = is_array($request->certifications) ? $request->certifications : explode(',', $request->certifications);
            foreach ($certList as $cName) {
                if (!empty(trim($cName))) {
                    BuilderCertification::create([
                        'builder_id'         => $builder->id,
                        'certification_name' => trim($cName),
                    ]);
                }
            }
        }

        // Save Service Areas
        if ($request->has('service_areas')) {
            BuilderServiceArea::where('builder_id', $builder->id)->delete();
            $areaList = is_array($request->service_areas) ? $request->service_areas : explode(',', $request->service_areas);
            foreach ($areaList as $city) {
                if (!empty(trim($city))) {
                    BuilderServiceArea::create([
                        'builder_id' => $builder->id,
                        'city_name'  => trim($city),
                    ]);
                }
            }
        }

        return redirect()->route('admin.builder.list')->with('success', $msg);
    }

    public function toggleVerify(Request $request)
    {
        $builder = Builder::find($request->id);
        if ($builder) {
            $builder->is_verified = !$builder->is_verified;
            $builder->save();
            return response()->json(['status' => true, 'message' => 'Verification badge updated successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Builder not found'], 404);
    }

    public function toggleStatus(Request $request)
    {
        $builder = Builder::find($request->id);
        if ($builder) {
            $builder->status = !$builder->status;
            $builder->save();
            return response()->json(['status' => true, 'message' => 'Status updated successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Builder not found'], 404);
    }

    public function delete($id)
    {
        $builder = Builder::find($id);
        if ($builder) {
            $builder->delete();
            return response()->json(['status' => true, 'message' => 'Builder deleted successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Builder not found'], 404);
    }
}
