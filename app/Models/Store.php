<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
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
    protected $table = 'stores';
    /**
     * model's attributes
     * @var array
     */
    protected $fillable = [
        'id',
        'store_name',
         'store_start_date',
          'store_logo',
          'store_size' ,
           'store_inventory_no' ,
           'store_employee_no' ,
           'store_notes' ,
            'store_business_record_no' ,
            'store_tax_no' ,
            'store_type_activity'  ,
            'store_product_type' ,
            'store_city_id' ,
             'store_address' ,
             'store_address_map' ,
             'store_mobil' ,
             'store_fax' ,
              'store_email' ,
              'store_timezone' ,
              'store_languange' ,
               'store_cuurency' ,
                'date_create_account' ,
                 'store_active_flag' ,
                 'custom_url' ,
                 'date_format' ,
                  'country_service'

    ];
}
