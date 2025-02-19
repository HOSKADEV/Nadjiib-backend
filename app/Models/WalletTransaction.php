<?php

namespace App\Models;

use Barryvdh\DomPDF\Facade\Pdf;
use Chargily\ChargilyPay\Auth\Credentials;
use Chargily\ChargilyPay\ChargilyPay;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class WalletTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'description',
        'payment_method',
        'status',
        'checkout_id',
        'receipt',
        'account',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receipt(){
      if($this->payment_method=='chargily' && $this->checkout_id && empty($this?->receipt) ){
        $credentials = new Credentials(json_decode(file_get_contents(base_path('chargily-pay-env.json')),true));
        $chargily_pay = new ChargilyPay($credentials);
        $checkout = $chargily_pay->checkouts()->get($this->checkout_id);

        if($checkout){
          $pdf = Pdf::loadView('checkout.pdf', compact('checkout'));
          $pdf->render();
          $filePath = 'documents/purchase/checkout/' . md5($this->checkout_id) . '.pdf';
          Storage::put($filePath, $pdf->output());
          $this->receipt = $filePath;
          $this->save();
        }
      }

      return $this->receipt;
    }

    public function receipt_is(){
      $filePath = $this?->receipt;

      if(empty($filePath)){
        return null;
      }

      $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
      $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'webp'];

      if (in_array($fileExtension, $imageExtensions)){
        return 'image';
      }else{
        return $fileExtension;
      }
    }



}
