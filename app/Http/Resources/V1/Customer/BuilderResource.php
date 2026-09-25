<?php

namespace App\Http\Resources\V1\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuilderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Specialization tags from services
        $tags = [];
        if ($this->relationLoaded('services') && $this->services->count() > 0) {
            $tags = $this->services->pluck('service_name')->take(3)->toArray();
        }

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
            'experience_years'    => (int) $this->experience_years,
            'projects_count'      => (int) $this->projects_count,
            'projects_count_text' => $this->projects_count . ' Projects',
            'rating'              => (float) $this->rating,
            'is_verified'         => (bool) $this->is_verified,
            'tags'                => $tags,
        ];
    }
}
