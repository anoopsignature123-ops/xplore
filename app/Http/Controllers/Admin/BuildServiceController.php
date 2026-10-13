<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\BuildService;
use App\Models\BuildServiceFaq;
use App\Models\BuildCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BuildServiceController extends Controller
{
    public function index()
    {
        $page_title = 'Build Services';
        return view('admin.build_service.list', compact('page_title'));
    }

    public function getRecords(Request $request)
    {
        $query = BuildService::with('category')->orderBy('sort_order')->orderByDesc('id');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('title', function ($row) {
                $cat = $row->category ? '<span class="badge bg-primary-subtle text-primary me-1">' . e($row->category->name) . '</span>' : '';
                return $cat . '<strong style="color:#1e293b !important;">' . e($row->title) . '</strong>';
            })
            ->editColumn('price', function ($row) {
                return '<strong class="text-success">₹' . number_format($row->price, 0) . '</strong>'
                    . ' <small class="text-muted">(' . $row->price_type . ')</small>';
            })
            ->editColumn('rating', function ($row) {
                return '<span class="text-warning"><i class="fas fa-star"></i></span> '
                    . number_format($row->rating, 1)
                    . ' <small class="text-muted">(' . $row->total_reviews . ')</small>';
            })
            ->editColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '<label class="custom-switch">
                            <input class="status-toggle" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                            <span class="slider"></span>
                        </label>';
            })
            ->addColumn('action', function ($row) {
                $editUrl   = route('admin.build-service.add', $row->id);
                $deleteUrl = route('admin.build-service.delete', $row->id);
                return '<a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button data-url="' . $deleteUrl . '" data-name="' . e($row->title) . '" class="btn btn-sm btn-danger delete-btn">
                            <i class="fas fa-trash-alt me-1"></i>Delete
                        </button>';
            })
            ->rawColumns(['title', 'price', 'rating', 'status', 'action'])
            ->make(true);
    }

    public function add($id = null)
    {
        $service    = $id ? BuildService::with('faqs')->findOrFail($id) : null;
        $categories = BuildCategory::where('status', 1)->orderBy('name')->get();
        $btn_title  = $service ? 'Update' : 'Add';
        $page_title = $service ? 'Edit Build Service' : 'Add Build Service';

        return view('admin.build_service.add', compact('service', 'categories', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $id = $request->input('id');

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:build_categories,id',
            'title'       => 'required|string|max:255',
            'short_desc'  => 'nullable|string|max:500',
            'price'       => 'required|numeric|min:0',
            'price_type'  => 'required|in:fixed,per_sqft,per_unit',
            'duration'    => 'nullable|string|max:100',
            'rating'      => 'nullable|numeric|min:1|max:5',
            'total_reviews' => 'nullable|integer|min:0',
            'overview'    => 'nullable|string',
            'status'      => 'required|in:0,1',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Parse tags (comma-separated → array)
        $tags = [];
        if ($request->filled('tags')) {
            $tags = array_values(array_filter(array_map('trim', explode(',', $request->tags))));
        }

        // Parse deliverables (one per line)
        $deliverables = [];
        if ($request->filled('deliverables')) {
            $deliverables = array_values(array_filter(array_map('trim', explode("\n", $request->deliverables))));
        }

        // Parse what_you_get (one per line)
        $whatYouGet = [];
        if ($request->filled('what_you_get')) {
            $whatYouGet = array_values(array_filter(array_map('trim', explode("\n", $request->what_you_get))));
        }

        // Parse execution_steps (title|description per line)
        $steps = [];
        if ($request->filled('execution_steps')) {
            foreach (explode("\n", $request->execution_steps) as $line) {
                $line = trim($line);
                if (!$line) continue;
                $parts = explode('|', $line, 2);
                $steps[] = [
                    'title'       => trim($parts[0] ?? ''),
                    'description' => trim($parts[1] ?? ''),
                ];
            }
        }

        $data = [
            'category_id'    => $request->category_id,
            'title'          => trim($request->title),
            'short_desc'     => trim($request->short_desc ?? ''),
            'price'          => $request->price,
            'price_type'     => $request->price_type,
            'duration'       => trim($request->duration ?? ''),
            'rating'         => $request->rating ?? 4.5,
            'total_reviews'  => $request->total_reviews ?? 0,
            'tags'           => $tags,
            'overview'       => trim($request->overview ?? ''),
            'deliverables'   => $deliverables,
            'what_you_get'   => $whatYouGet,
            'execution_steps'=> $steps,
            'sort_order'     => $request->sort_order ?? 0,
            'status'         => (int) $request->status,
        ];

        DB::beginTransaction();
        try {
            if ($id) {
                $service = BuildService::findOrFail($id);
                $service->update($data);
                $msg = 'Service updated successfully!';
            } else {
                $service = BuildService::create($data);
                $msg = 'Service created successfully!';
            }

            // Save FAQs
            $service->faqs()->delete();
            $questions = $request->input('faq_question', []);
            $answers   = $request->input('faq_answer', []);
            foreach ($questions as $i => $q) {
                $q = trim($q ?? '');
                $a = trim($answers[$i] ?? '');
                if ($q && $a) {
                    BuildServiceFaq::create([
                        'build_service_id' => $service->id,
                        'question'         => $q,
                        'answer'           => $a,
                        'sort_order'       => $i,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to save: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('admin.build-service.list')->with('success', $msg);
    }

    public function toggleStatus(Request $request)
    {
        $service = BuildService::find($request->id);
        if ($service) {
            $service->status = $service->status ? 0 : 1;
            $service->save();
            return response()->json(['status' => true, 'message' => 'Status updated successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record not found'], 404);
    }

    public function delete($id)
    {
        $service = BuildService::find($id);
        if ($service) {
            $service->faqs()->delete();
            $service->delete();
            return response()->json(['status' => true, 'message' => 'Service deleted successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Record not found'], 404);
    }
}
