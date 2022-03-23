<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TravelPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'created_at' => $this->created_at->isoFormat('Y-MM-DD HH:mm:ss'),
            'updated_at' => $this->updated_at->isoFormat('Y-MM-DD HH:mm:ss'),
            'user' => new UserResource(
                $this->whenLoaded('user')
            )
        ];
    }
}
