<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Yajra\DataTables\DataTables;
use App\Models\Slider;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller {

    public function index() {
         $page_title = 'Slider List';
         return view('admin.slider.list', compact('page_title'));
    }
    

    public function add($id = null) {
        $slider = !empty($id) ? Slider::find($id) : null;
        if ($id && !$slider) { 
            return redirect()->route('admin.slider.list')->with('error', 'Record Not Found');
        }
        $btn_title  = $slider ? 'Update' : 'Submit';
        $page_title = $slider ? 'Update Slider' : 'Add Slider';
        return view('admin.slider.add', compact('slider', 'btn_title', 'page_title'));
    }


  
    public function save(Request $request)
{
    $input = $request->all();
    $id = $input['id'] ?? null;

    $rules = [
        'type' => 'required|string',
        'name' => 'required|string|max:255', 
        'status' => 'required|in:Active,Inactive',
        'image' => $id ? 'nullable|image|mimes:jpg,jpeg,png' : 'required|image|mimes:jpg,jpeg,png',
    ];

    $validator = Validator::make($input, $rules);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    // find or create 
    $slider = Slider::find($id);

    if ($id && !$slider) {
        return response()->json([
            'message' => 'Record Not Found'
        ], 404);
    }

    if (!$slider) {
        $slider = new Slider();
    }


    // assign fields
    $slider->type = trim($input['type']);
    $slider->name = trim($input['name']);
    $slider->status = $input['status'];


    // image upload
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $uploaded = uploadImage($file,'slider',$slider->image ?? '');
        $slider->image = $uploaded['image'] ?? null;
    }

    $slider->save();

    return response()->json([
        'success' => true, 'message' => $id ? 'Slider updated successfully.' : 'Slider added successfully.'
    ]);
}



    public function getRecords(Request $request) 
    {
        if ($request->ajax()) {     
             $query = Slider::select(['id', 'name', 'type', 'image', 'status']);
      

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
                
                    ->editColumn('type', function ($row) {
                    return ucfirst($row->type);
                    })
              
                 ->editColumn('status', function ($row) {
                    if (!auth()->user()->can('slider-add')) {
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
                    $editUrl = route('admin.slider.add', $row->id);
                    $btn = '';
                    if(auth()->user()->can('slider-add')) {
                        $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a> ';
                    } 
                    if(auth()->user()->can('slider-delete')) {
                        $btn .= '<a title="Delete Record" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
    }
 


    public function delete(Request $request)
    {
         if (!auth()->user()->can('slider-delete')) {
        return response()->json([
            'status' => false,
            'message' => 'Permission denied'
        ], 403);
    }

        $id = $request->get('id');
        $slider = Slider::find($id);

        if($slider){
            $slider->delete();
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
        $slider = Slider::find($request->id);
        if ($slider) {
            $slider->status = $request->status;
            $slider->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}
