<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * model's table
     *
     * @author Amr
     * @var string
     */
    protected $table = 'currencies';
    /**
     * model's attributes
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'currency_icon',
        'user_id',
        'is_active',

    ];
}
