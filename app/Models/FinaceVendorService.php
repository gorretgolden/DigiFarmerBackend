<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FinaceVendorService
 * @package App\Models
 * @version December 7, 2022, 11:11 am UTC
 *
 * @property string $name
 * @property integer $principal
 * @property integer $interest_rate
 * @property string $interest_rate_unit
 * @property integer $payment_frequency_pay
 * @property string $duration_unit
 * @property integer $duration
 * @property string $payment_frequency
 * @property string $status
 * @property integer $simple_interest
 * @property integer $total_amount_paid_back
 * @property integer $vendor_category_id
 * @property integer $user_id
 */
class FinaceVendorService extends Model
{



    //belongs to a user
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class,'user_id');
    }
}
