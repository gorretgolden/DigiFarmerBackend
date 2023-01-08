<?php

namespace App\Http\Controllers;


use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Flash;
use Response;

class GeneralSettingController extends Controller
{

    public function index(Request $request,GeneralSettings $settings)
    {
        return view('general_settings.index', [
            'commission' => $settings->commission,
            'commission_unit' => $settings->commission_unit,
            'app_name' => $settings->app_name,
            'currency_unit' => $settings->currency_unit
        ]);
    }

  //get settings data
    public function  getSettings(GeneralSettings $settings){
        return view('general_settings.index', [
            'commission' => $settings->commission,
            'commission_unit' => $settings->commission_unit,
            'app_name' => $settings->app_name,
            'currency_unit' => $settings->currency_unit
        ]);

    }

    public function edit(GeneralSettings $settings)
    {

        return view('general_settings.edit');
    }



   //update settings
   public function updateSettings(GeneralSettings $settings,Request $request){

    $rules = [
        'commission' => 'required|integer',
        'app_name' => 'required|string',


    ];
    $request->validate($rules);
    //dd($request->all());


     $settings->commission = $request->commission;
     $settings->app_name = $request->app_name;
     $settings->commission_unit = "%";
     $settings->currency_unit = $request->currency_unit;

     $settings->save();

     Flash::success('Settings updated successfully.');

     return redirect(route('generalSettings.index'));
}





}
