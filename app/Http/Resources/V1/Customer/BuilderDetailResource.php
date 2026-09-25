<?php

namespace App\Http\Resources\V1\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuilderDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Services offered array
        $services = $this->services ? $this->services->pluck('service_name')->toArray() : [];

        // Certifications array
        $certifications = $this->certifications ? $this->certifications->pluck('certification_name')->toArray() : [];

        // Service Areas array
        $serviceAreas = $this->serviceAreas ? $this->serviceAreas->pluck('city_name')->toArray() : [];

        // Portfolio gallery
        $portfolios = $this->portfolios ? $this->portfolios->map(function ($p) {
            return [
                'id'        => (int) $p->id,
                'title'     => (string) ($p->title ?? ''),
                'image_url' => !empty($p->image_url) ? asset($p->image_url) : '',
            ];
        }) : [];

        // Completed Projects
        $completedProjects = $this->completedProjects ? $this->completedProjects->map(function ($cp) {
            return [
                'id'            => (int) $cp->id,
                'project_title' => (string) $cp->project_title,
                'location'      => (string) ($cp->location ?? ''),
                'area_details'  => (string) ($cp->area_details ?? ''),
                'image'         => !empty($cp->image) ? asset($cp->image) : null,
            ];
        }) : [];

        // Reviews
        $reviews = $this->reviews ? $this->reviews->where('status', 1)->map(function ($r) {
            return [
                'id'             => (int) $r->id,
                'customer_name'  => (string) $r->customer_name,
                'customer_image' => !empty($r->customer_image) ? asset($r->customer_image) : null,
                'rating'         => (float) $r->rating,
                'review_text'    => (string) $r->review_text,
                'created_at'     => $r->created_at ? $r->created_at->format('d M Y') : '',
            ];
        }) : [];

        return [
            'id'                  => (int) $this->id,
            'category_id'         => (int) $this->category_id,
            'category_name'       => $this->category ? $this->category->name : '',
            'name'                => (string) $this->name,
            'firm_name'           => (string) $this->firm_name,
            'slug'                => (string) $this->slug,
            'profile_image'       => !empty($this->profile_image) ? asset($this->profile_image) : null,
            'cover_image'         => !empty($this->cover_image) ? asset($this->cover_image) : null,
            'location'            => (string) ($this->location ?? ''),
            'address'             => (string) ($this->address ?? ''),
            'website'             => (string) ($this->website ?? ''),
            'phone'               => (string) ($this->phone ?? ''),
            'email'               => (string) ($this->email ?? ''),
            'about'               => (string) ($this->about ?? ''),
            'experience_years'    => (int) $this->experience_years,
            'experience_text'     => $this->experience_years . ' Yrs Exp',
            'projects_count'      => (int) $this->projects_count,
            'projects_count_text' => $this->projects_count . ' Projects',
            'rating'              => (float) $this->rating,
            'is_verified'         => (bool) $this->is_verified,
            'services'            => $services,
            'certifications'      => $certifications,
            'service_areas'       => $serviceAreas,
            'portfolios'          => $portfolios,
            'completed_projects'  => $completedProjects,
            'reviews'             => $reviews,
        ];
    }
}
