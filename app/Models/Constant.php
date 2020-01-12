<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\ConstantTransformer;


class Constant extends Model
{
    use SoftDeletes;
    
    public $transformer = ConstantTransformer::class;

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

      public function getNameAttribute()
    {
        $name = $this->attributes['name'];
        if (!$name)
            return $name;
        $name = json_decode($name);
        $lang = app()->getLocale();
        // dd($name);
        return $name->$lang;
    }



    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
