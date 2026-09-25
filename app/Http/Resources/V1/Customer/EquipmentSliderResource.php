<?php

namespace App\Http\Resources\V1\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentSliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => (int) $this->id,
            'name'  => (string) ($this->name ?? ''),
            'title' => (string) ($this->name ?? ''),
            'image' => !empty($this->image) ? asset($this->image) : '',
        ];
    }
}
