<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Constant extends Model
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
    protected $table = 'constants';
    /**
     * model's attributes
     * @var array
     */

    protected $casts = [
        'name' => 'array'
    ];
    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'user_id',
        'is_active',

    ];
}
