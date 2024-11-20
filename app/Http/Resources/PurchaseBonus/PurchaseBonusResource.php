<?php

namespace App\Http\Resources\PurchaseBonus;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseBonusResource extends JsonResource
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
          'type' => $this->type,
          'percentage' => $this->percentage,
          'amount' => $this->amount,
        ];
    }
}
