<?php

namespace App\Models;

use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
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
    protected $table = 'plans';
    /**
     * model's attributes
     * @var array
     */

    protected $casts = [
        'modules' => 'array'
    ];
    protected $fillable = [
        'id',
        'title',
        'price_month',
        'price_year',
        'currency_id',
        'plan_level',
        'no_featured_items',
        'no_sales_transaction',
        'no_emp',
        'no_item',
        'is_active',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
        'is_trial',
        'interval_trail',
        'no_transactions',
        'percent_price_sales_transaction',
        'total_price_sales',
        'details_reports',
        'is_support',
        'is_mix_store',

    ];

    protected $with = ['modules', 'currency', 'store'];

    protected $hidden = ['user_id'];


    public static $columns = [
        [
            'label' => 'Title',
            'field' => 'title',
        ],
        [
            'label' => 'Currency',
            'field' => 'currency.name',
        ],
        [
            'label' => 'Plan Level',
            'field' => 'plan_level',
        ],
        [
            'label' => 'Trial',
            'field' => 'is_trial',
            'is_trial' => 1

        ],
        [
            'label' => 'Status',
            'field' => 'is_active',
            'status' => 1
        ],
        [
            'label' => 'Operations',
            'field' => 'id',
            'html' => true,
            'showObject' => true
        ]
    ];

    /**
     * plan modules
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Amr
     */
    public function modules()
    {
        return $this->hasMany(PlanModule::class);
    }


    function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    function store()
    {
        return $this->hasOne(Store::class);
    }
}
