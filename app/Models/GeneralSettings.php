<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    use HasFactory;

    public int $commission;
    public string $commission_unit;
    public string $app_name;
    public string $currency_unit;


    public static function group(): string
    {
        return 'general';
    }


    //get default commsion
    public static function getCommission(): string{
        return app(GeneralSettings::class)->commission;
    }

     //get default commission unit
     public static function getCommissionUnit(): string{
        return app(GeneralSettings::class)->commission_unit;
    }

     //get app name
     public static function getAppName(): string{
        return app(GeneralSettings::class)->app_name;
    }

    public static function getCurrencyUnit(): string{
        return app(GeneralSettings::class)->currency_unit;
    }
}
