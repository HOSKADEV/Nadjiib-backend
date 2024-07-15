<?php

namespace App\Http\Resources\Payment;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
      'amount' => number_format($this->amount, 2),
      'date' => Carbon::createFromDate($this->date)->format('Y-m'),
      'is_paid' => $this->is_paid,
      'paid_at' => $this->paid_at,
      'is_confirmed' => $this->is_confirmed,
      'confirmed_at' => $this->confirmed_at,
      'payment_method' => $this->payment_method,
      'receipt' => $this->receipt,
    ];
  }
}
