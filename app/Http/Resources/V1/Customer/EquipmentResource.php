<?php

namespace App\Http\Resources\V1\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\EquipmentWishlist;

class EquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();
        $isWishlisted = false;

        if ($user) {
            $isWishlisted = EquipmentWishlist::where('customer_id', $user->id)
                ->where('equipment_id', $this->id)
                ->exists();
        }

        // Base Specifications
        $specifications = [
            ['key' => 'Brand', 'value' => (string) ($this->brand ?? 'N/A')],
            ['key' => 'Model', 'value' => (string) ($this->model ?? 'N/A')],
            ['key' => 'Accuracy', 'value' => (string) ($this->accuracy ?? 'N/A')],
            ['key' => 'Availability', 'value' => ucwords(str_replace('_', ' ', (string) $this->availability_status))],
        ];

        // Append custom specs if relation is loaded
        if ($this->relationLoaded('specifications') && $this->specifications->count() > 0) {
            foreach ($this->specifications as $spec) {
                $specifications[] = [
                    'key'   => (string) $spec->spec_key,
                    'value' => (string) $spec->spec_value,
                ];
            }
        }

        // Rental Plans
        $dailyRate = (float) $this->daily_rate;
        $weeklyRate = (float) ($this->weekly_rate > 0 ? $this->weekly_rate : ($dailyRate * 6));
        $monthlyRate = (float) ($this->monthly_rate > 0 ? $this->monthly_rate : ($dailyRate * 20));

        $rentalPlans = [
            ['duration' => 'Daily', 'rate' => $dailyRate, 'label' => '₹' . number_format($dailyRate)],
            ['duration' => 'Weekly', 'rate' => $weeklyRate, 'label' => '₹' . number_format($weeklyRate)],
            ['duration' => 'Monthly', 'rate' => $monthlyRate, 'label' => '₹' . number_format($monthlyRate)],
        ];

        return [
            'id'                  => (int) $this->id,
            'name'                => (string) $this->name,
            'slug'                => (string) $this->slug,
            'image'               => !empty($this->image) ? asset($this->image) : null,
            'brand'               => (string) ($this->brand ?? ''),
            'model'               => (string) ($this->model ?? ''),
            'accuracy'            => (string) ($this->accuracy ?? ''),
            'description'         => (string) ($this->description ?? ''),
            'availability_status' => (string) $this->availability_status,
            'daily_rate'          => $dailyRate,
            'daily_rate_label'    => '₹' . number_format($dailyRate) . '/day',
            'weekly_rate'         => $weeklyRate,
            'monthly_rate'        => $monthlyRate,
            'security_deposit'    => (float) $this->security_deposit,
            'gst_percentage'      => (float) $this->gst_percentage,
            'is_popular'          => (bool) $this->is_popular,
            'is_wishlisted'       => (bool) $isWishlisted,
            'specifications'      => $specifications,
            'rental_plans'        => $rentalPlans,
        ];
    }
}
