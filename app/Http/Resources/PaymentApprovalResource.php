<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentApprovalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'payment_id' => $this->payment_id,
            'payment_type' => $this->payment_type,
            'status' => $this->status,
            'created_at' => $this->created_at->isoFormat('Y-MM-DD HH:mm:ss'),
            'updated_at' => $this->updated_at->isoFormat('Y-MM-DD HH:mm:ss'),
            'user' => new UserResource(
                $this->whenLoaded('user')
            ),
            'payment' => new PaymentResource(
                $this->whenLoaded('payment')
            ),
            'travel_payment' => new TravelPaymentResource(
                $this->whenLoaded('travel_payment')
            )
        ];
    }
}
