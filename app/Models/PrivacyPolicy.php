<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PrivacyPolicy
 * @package App\Models
 * @version December 20, 2022, 4:25 am CET
 *
 * @property string $title
 * @property string $description
 */
class PrivacyPolicy extends Model
{

    use HasFactory;

    public $table = 'privacy_policies';




    public $fillable = [
        'title',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string',
        'description' => 'required|string'
    ];


}
