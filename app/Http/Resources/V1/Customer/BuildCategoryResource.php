<?php

namespace App\Http\Resources\V1\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'     => (int) $this->id,
            'name'   => (string) $this->name,
            'slug'   => (string) $this->slug,
            'icon'   => !empty($this->icon) ? asset($this->icon) : null,
            'status' => (bool) $this->status,
        ];
    }
}
