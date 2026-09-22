<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;
use Yajra\DataTables\DataTables;

class CmsController extends Controller
{
    public function index(Request $request) 
    {
        $page_title = 'CMS Pages';
        return view('admin.cms.list', compact('page_title'));
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = Cms::orderBy('id', 'desc'); 

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('cms-add')) {
                        $html .= '<a href="' . route('admin.cms.add', $row->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a> ';
                    }
                    return $html;
                }) 
                ->editColumn('pagename', function ($row) {
                    return ucwords(str_replace('_', ' ', $row->pagename));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add($id = null)
    {
        $page_title = $id ? 'Edit CMS Page' : 'Add CMS Page';
        $data = $id ? Cms::findOrFail($id) : new Cms();
        
        $pages = [
            'privacy_policy' => 'Privacy Policy',
            'terms_conditions' => 'Terms & Conditions',
            'about_us' => 'About Us',
            'contact_us' => 'Contact Us',
        ];

        return view('admin.cms.add', compact('page_title', 'data', 'pages'));
    }

    public function save(Request $request)
    {
        $rules = [
            'pagename' => 'required|in:privacy_policy,terms_conditions,about_us,contact_us|unique:cms,pagename,' . $request->id,
            'heading' => 'required|string|max:255',
            'description' => 'required',
        ];

        $request->validate($rules);

        try {
            if ($request->id) {
                $cms = Cms::findOrFail($request->id); 
                $msg = 'CMS Page updated successfully';
            } else {
                $cms = new Cms();
                $msg = 'CMS Page added successfully';
            }

            $cms->pagename = $request->pagename;
            $cms->heading = $request->heading;
            $cms->description = $request->description;
            $cms->save();

            return response()->json(['status' => true, 'message' => $msg]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

  
}
