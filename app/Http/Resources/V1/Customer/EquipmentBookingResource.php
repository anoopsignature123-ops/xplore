<?php

namespace App\Http\Resources\V1\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                   => (int) $this->id,
            'booking_number'       => (string) $this->booking_number,
            'equipment'            => $this->equipment ? new EquipmentResource($this->equipment) : null,
            'rental_duration_days' => (int) $this->rental_duration_days,
            'daily_rate'           => (float) $this->daily_rate,
            'rental_cost'          => (float) $this->rental_cost,
            'security_deposit'     => (float) $this->security_deposit,
            'gst_amount'           => (float) $this->gst_amount,
            'total_amount'         => (float) $this->total_amount,
            'delivery_type'        => (string) $this->delivery_type,
            'delivery_address'     => (string) ($this->delivery_address ?? ''),
            'latitude'             => (string) ($this->latitude ?? ''),
            'longitude'            => (string) ($this->longitude ?? ''),
            'booking_status'       => (string) $this->booking_status,
            'payment_status'       => (string) $this->payment_status,
            'payment_method'       => (string) ($this->payment_method ?? ''),
            'razorpay_order_id'    => (string) ($this->razorpay_order_id ?? ''),
            'created_at'           => $this->created_at ? $this->created_at->toDateTimeString() : null,
        ];
    }
}
