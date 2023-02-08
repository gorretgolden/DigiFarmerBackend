<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalFeedCart extends Model
{
    use HasFactory;

    public $table = 'animal_feed_cart';


    public $fillable = [
        'cart_id',
        'animal_feed_id'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

        'cart_id'=>'integer',
        'animal_feed_id'=>'integer'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'cart_id' => 'required|integer',
        'animal_feed_id' => 'required|integer'

    ];
}
