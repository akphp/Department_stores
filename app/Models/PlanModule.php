<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanModule extends Model
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
    protected $table = 'plan_modules';
    /**
     * model's attributes
     * @var array
     */
    protected $fillable = [
        'id',
        'plan_id',
        'module_id',
        'user_id',
        'is_active',

    ];
}
