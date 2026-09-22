<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Yajra\DataTables\DataTables;
use App\Models\Survey;
 
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller {

    public function index() {
         $page_title = 'Survey List';
         return view('admin.survey.list', compact('page_title'));
    }
     

    public function add($id = null) {
        $survey = !empty($id) ? Survey::find($id) : null;
        if ($id && !$survey) { 
            return redirect()->route('admin.survey.list')->with('error', 'Record Not Found');
        } 
        $btn_title  = $survey ? 'Update' : 'Submit';  
        $page_title = $survey ? 'Update Survey' : 'Add Survey';
        return view('admin.survey.add', compact('survey', 'btn_title', 'page_title'));
    }


  

    public function save(Request $request)
{
    $id = $request->id;

    $rules = [
        'name' => 'required|string|max:255',
        'short_detail' => 'nullable|string',
        'amount' => 'required|string|min:0',
        'status' => 'required|in:Active,Inactive',
        'image' => $id ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
                       : 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $exists = Survey::where('name', $request->name);

    if ($id) {
        $exists->where('id', '!=', $id);
    }

    if ($exists->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'Survey already exists'
        ], 422);
    }

    $survey = $id ? Survey::find($id) : new Survey();

    if ($id && !$survey) {
        return response()->json([ 
            'success' => false,
            'message' => 'Record Not Found'
        ], 404);
    }

    $survey->name = trim($request->name);
    $survey->short_detail = $request->short_detail;
    $survey->amount = $request->amount;
    $survey->status = $request->status;

  


     if ($request->hasFile('image')) {
        $file = $request->file('image');
        $uploaded = uploadImage($file,'survey',$survey->image ?? '');
        $survey->image = $uploaded['image'] ?? null;
    }

    $survey->save(); 

    return response()->json([
        'success' => true,
        'message' => $id ? 'Survey Updated Successfully' : 'Survey Added Successfully'
    ]);
} 



    public function getRecords(Request $request) 
    {
        if ($request->ajax()) {     
            $query = Survey::select(['id','name','amount','image','status']);
      

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
                
              
                 ->editColumn('status', function ($row) {
                    if (!auth()->user()->can('survey-add')) {
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
                        $editUrl = route('admin.survey.add', $row->id);
                        $btn = ''; 
                        if(auth()->user()->can('survey-add')) {
                            $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a> ';
                        } 
                        if(auth()->user()->can('survey-delete')) {
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

     if (!auth()->user()->can('survey-delete')) {
        return response()->json([
            'status' => false,
            'message' => 'Permission denied'
        ], 403);
    }
    
        $id = $request->get('id');
        $survey = Survey::find($id);

        if($survey){
            $survey->delete();
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
        $survey = Survey::find($request->id);
        if ($survey) {
            $survey->status = $request->status;
            $survey->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record Not Found']);
    }
}
