<?php

namespace App\Http\Resources\Coupons;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
          'id '         => $this->id,
          'code '       => $this->code,
          'type'        => $this->type,
          'discount'    => $this->discount,
          'start_date'  => date('d-m-Y',strtotime($this->start_date)),
          'end_date'    => date('d-m-Y',strtotime($this->end_date)),
          'created'     => $this->created_at->format('d-m-Y'),
        ];
    }
}
