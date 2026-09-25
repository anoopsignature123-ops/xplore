<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Equipment;
use App\Models\EquipmentSpecification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EquipmentController extends Controller
{
    public function index()
    {
        $page_title = 'Equipment List';
        return view('admin.equipment.list', compact('page_title'));
    }

    public function getRecords(Request $request)
    {
        $query = Equipment::query()->orderBy('id', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('image', function ($row) {
                if ($row->image) {
                    $url = asset($row->image);
                    return '<img src="' . $url . '" alt="' . e($row->name) . '" style="height: 50px; width: 50px; object-fit: cover; border-radius: 4px;">';
                }
                return '<span class="text-muted">No Image</span>';
            })
            ->editColumn('daily_rate', function ($row) {
                return '<strong class="text-success"><i class="fas fa-rupee-sign"></i> ' . number_format($row->daily_rate, 2) . ' / day</strong>';
            })
            ->editColumn('availability_status', function ($row) {
                $statusMap = [
                    'in_stock' => '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>In Stock</span>',
                    'out_of_stock' => '<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Out of Stock</span>',
                    'maintenance' => '<span class="badge bg-warning text-dark"><i class="fas fa-wrench me-1"></i>Maintenance</span>',
                ];
                return $statusMap[$row->availability_status] ?? $row->availability_status;
            })
            ->editColumn('is_popular', function ($row) {
                return $row->is_popular 
                    ? '<span class="badge bg-primary"><i class="fas fa-fire me-1"></i>Popular</span>' 
                    : '<span class="badge bg-secondary"><i class="fas fa-box me-1"></i>Standard</span>';
            })
            ->editColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '<label class="custom-switch">
                            <input class="status-toggle" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                            <span class="slider"></span>
                        </label>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.equipment.add', $row->id);
                $deleteUrl = route('admin.equipment.delete', $row->id);

                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1" title="Edit"><i class="fas fa-edit me-1"></i> Edit</a>
                    <button data-url="' . $deleteUrl . '" class="btn btn-sm btn-danger delete-btn" title="Delete"><i class="fas fa-trash-alt me-1"></i> Delete</button>
                ';
            })
            ->rawColumns(['image', 'daily_rate', 'availability_status', 'is_popular', 'status', 'action'])
            ->make(true);
    }

    public function add($id = null)
    {
        $equipment = !empty($id) ? Equipment::with('specifications')->find($id) : null;

        if ($id && !$equipment) {
            return redirect()->route('admin.equipment.list')->with('error', 'Equipment Not Found');
        }

        $btn_title  = $equipment ? 'Update' : 'Submit';
        $page_title = $equipment ? 'Update Equipment' : 'Add Equipment';

        return view('admin.equipment.add', compact('equipment', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $id = $request->input('id');

        $rules = [
            'name'                => 'required|string|max:255',
            'brand'               => 'nullable|string|max:255',
            'model'               => 'nullable|string|max:255',
            'accuracy'            => 'nullable|string|max:255',
            'description'         => 'required|string',
            'availability_status' => 'required|in:in_stock,out_of_stock,maintenance',
            'daily_rate'          => 'required|numeric|min:0',
            'weekly_rate'         => 'nullable|numeric|min:0',
            'monthly_rate'        => 'nullable|numeric|min:0',
            'security_deposit'    => 'required|numeric|min:0',
            'gst_percentage'      => 'required|numeric|min:0|max:100',
            'is_popular'          => 'nullable|boolean',
            'status'              => 'required|boolean',
            'image'               => $id ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120' : 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'name'                => $request->name,
            'slug'                => Str::slug($request->name) . ($id ? '' : '-' . time()),
            'brand'               => $request->brand,
            'model'               => $request->model,
            'accuracy'            => $request->accuracy,
            'description'         => $request->description,
            'availability_status' => $request->availability_status,
            'daily_rate'          => $request->daily_rate,
            'weekly_rate'         => $request->weekly_rate ?? ($request->daily_rate * 6),
            'monthly_rate'        => $request->monthly_rate ?? ($request->daily_rate * 20),
            'security_deposit'    => $request->security_deposit,
            'gst_percentage'      => $request->gst_percentage ?? 18,
            'is_popular'          => $request->has('is_popular') ? 1 : 0,
            'status'              => $request->status ? 1 : 0,
        ];

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $path = 'uploads/equipments/';
            $image->move(public_path($path), $imageName);
            $data['image'] = $path . $imageName;

            // Delete old image if updating
            if ($id) {
                $oldEquipment = Equipment::find($id);
                if ($oldEquipment && $oldEquipment->image && file_exists(public_path($oldEquipment->image))) {
                    @unlink(public_path($oldEquipment->image));
                }
            }
        }

        if ($id) {
            $equipment = Equipment::findOrFail($id);
            $equipment->update($data);
            $msg = 'Equipment updated successfully!';
        } else {
            $equipment = Equipment::create($data);
            $msg = 'Equipment added successfully!';
        }

        // Save specifications if provided
        if ($request->has('spec_keys') && is_array($request->spec_keys)) {
            EquipmentSpecification::where('equipment_id', $equipment->id)->delete();
            foreach ($request->spec_keys as $index => $key) {
                if (!empty($key) && isset($request->spec_values[$index])) {
                    EquipmentSpecification::create([
                        'equipment_id' => $equipment->id,
                        'spec_key'     => $key,
                        'spec_value'   => $request->spec_values[$index],
                    ]);
                }
            }
        }

        return redirect()->route('admin.equipment.list')->with('success', $msg);
    }

    public function toggleStatus(Request $request)
    {
        $equipment = Equipment::find($request->id);
        if ($equipment) {
            $equipment->status = !$equipment->status;
            $equipment->save();
            return response()->json(['status' => true, 'message' => 'Status updated successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Equipment not found'], 444);
    }

    public function delete($id)
    {
        $equipment = Equipment::find($id);
        if ($equipment) {
            $equipment->delete();
            return response()->json(['status' => true, 'message' => 'Equipment deleted successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Equipment not found'], 444);
    }
}
