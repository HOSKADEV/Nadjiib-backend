<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use ProtoneMedia\LaravelMixins\Request\ConvertsBase64ToFiles;

class ImageRequest extends FormRequest
{
    use ConvertsBase64ToFiles;

    protected function base64FileKeys(): array
    {
        return [
            'image' => 'image.jpg',
        ];
    }

    public function rules()
    {
        return [
            'image' => ['required', 'file', 'image'],
        ];
    }
}
