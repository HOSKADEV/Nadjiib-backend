<?php

namespace App\Http\Controllers\Dashboard\AppSetting;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;



class AppSettingController extends Controller{

  public function index(){
    $appSettings = AppSetting::all();
    return view('dashboard.appsetting.index', compact('appSettings'));
  }





  public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|unique:app_settings,key',
            'value_type' => 'required|in:boolean,text',
        ]);

        if ($data['value_type'] === 'boolean') {
            // Convert to boolean
            $value = $request->input('boolean_value') === 'true';
        } elseif ($data['value_type'] === 'text') {
            $textType = $request->input('text_type');
            if ($textType === 'key_value') {
                $keyValues = $request->input('key_values', []);
                $value = [];
                foreach ($keyValues as $pair) {
                    if (!empty($pair['key']) && isset($pair['value'])) {
                        $value[$pair['key']] = $pair['value'];
                    }
                }
            } elseif ($textType === 'array') {
                $value = $request->input('array_values', []);
            } else {
                $value = null;
            }
        } else {
            $value = null;
        }

        AppSetting::create([
            'key'   => $request->input('key'),
            'value' => json_encode($value),
        ]);

        return redirect()->back()->with('success', 'App setting created successfully.');
    }

    /**
     * Update an existing app setting.
     */
    public function update(Request $request, AppSetting $setting)
    {
        $data = $request->validate([
            'key' => 'required|string|unique:app_settings,key,' . $setting->id,
            'value_type' => 'required|in:boolean,text',
        ]);

        if ($data['value_type'] === 'boolean') {
            $value = $request->input('boolean_value') === 'true';
        } elseif ($data['value_type'] === 'text') {
            $textType = $request->input('text_type');
            if ($textType === 'key_value') {
                $keyValues = $request->input('key_values', []);
                $value = [];
                foreach ($keyValues as $pair) {
                    if (!empty($pair['key']) && isset($pair['value'])) {
                        $value[$pair['key']] = $pair['value'];
                    }
                }
            } elseif ($textType === 'array') {
                $value = $request->input('array_values', []);
            } else {
                $value = null;
            }
        } else {
            $value = null;
        }

        $setting->update([
            'key'   => $request->input('key'),
            'value' => json_encode($value),
        ]);

        return redirect()->back()->with('success', 'App setting updated successfully.');
    }
}
