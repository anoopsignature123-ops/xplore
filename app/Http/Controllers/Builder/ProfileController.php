<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\BuilderService;
use App\Models\BuilderCertification;
use App\Models\BuilderServiceArea;
use App\Models\BuilderPortfolio;
use App\Models\BuilderCompletedProject;

class ProfileController extends Controller
{
    public function index()
    {
        $builder = Auth::guard('builder')->user()->load(['services', 'certifications', 'serviceAreas', 'portfolios', 'completedProjects']);
        $page_title = 'My Profile & Portfolio';

        return view('builder.profile', compact('builder', 'page_title'));
    }

    public function save(Request $request)
    {
        $builder = Auth::guard('builder')->user();

        $request->validate([
            'name'             => 'required|string|max:255',
            'firm_name'        => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
            'location'         => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'projects_count'   => 'required|integer|min:0',
            'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'cover_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = [
            'name'             => $request->name,
            'firm_name'        => $request->firm_name,
            'phone'            => $request->phone,
            'location'         => $request->location,
            'address'          => $request->address,
            'website'          => $request->website,
            'about'            => $request->about,
            'experience_years' => $request->experience_years,
            'projects_count'   => $request->projects_count,
        ];

        if ($request->hasFile('profile_image')) {
            $img = $request->file('profile_image');
            $fileName = 'profile_' . time() . '_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
            $path = 'uploads/builders/';
            $img->move(public_path($path), $fileName);
            $data['profile_image'] = $path . $fileName;
        }

        if ($request->hasFile('cover_image')) {
            $img = $request->file('cover_image');
            $fileName = 'cover_' . time() . '_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
            $path = 'uploads/builders/';
            $img->move(public_path($path), $fileName);
            $data['cover_image'] = $path . $fileName;
        }

        $builder->update($data);

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

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $builder = Auth::guard('builder')->user();

        if (!Hash::check($request->old_password, $builder->password)) {
            return redirect()->back()->with('error', 'Current password does not match.');
        }

        $builder->password = Hash::make($request->new_password);
        $builder->save();

        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    public function addPortfolio(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'title' => 'nullable|string|max:255',
        ]);

        $builder = Auth::guard('builder')->user();

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $fileName = 'portfolio_' . time() . '_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
            $path = 'uploads/builders/portfolios/';
            $img->move(public_path($path), $fileName);

            BuilderPortfolio::create([
                'builder_id' => $builder->id,
                'title'      => $request->title,
                'image_url'  => $path . $fileName,
            ]);
        }

        return redirect()->back()->with('success', 'Portfolio photo added!');
    }

    public function deletePortfolio($id)
    {
        $builder = Auth::guard('builder')->user();
        $portfolio = BuilderPortfolio::where('builder_id', $builder->id)->where('id', $id)->first();
        if ($portfolio) {
            $portfolio->delete();
            return redirect()->back()->with('success', 'Portfolio item deleted!');
        }
        return redirect()->back()->with('error', 'Item not found.');
    }

    public function addProject(Request $request)
    {
        $request->validate([
            'project_title' => 'required|string|max:255',
            'location'      => 'nullable|string|max:255',
            'area_details'  => 'nullable|string|max:255',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $builder = Auth::guard('builder')->user();
        $imgPath = null;

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $fileName = 'proj_' . time() . '_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
            $path = 'uploads/builders/projects/';
            $img->move(public_path($path), $fileName);
            $imgPath = $path . $fileName;
        }

        BuilderCompletedProject::create([
            'builder_id'    => $builder->id,
            'project_title' => $request->project_title,
            'location'      => $request->location,
            'area_details'  => $request->area_details,
            'image'         => $imgPath,
        ]);

        return redirect()->back()->with('success', 'Completed project showcase added!');
    }

    public function deleteProject($id)
    {
        $builder = Auth::guard('builder')->user();
        $project = BuilderCompletedProject::where('builder_id', $builder->id)->where('id', $id)->first();
        if ($project) {
            $project->delete();
            return redirect()->back()->with('success', 'Project showcase deleted!');
        }
        return redirect()->back()->with('error', 'Project not found.');
    }
}
