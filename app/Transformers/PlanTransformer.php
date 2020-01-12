<?php
namespace App\Transformers;
use App\Models\plan;
use League\Fractal\TransformerAbstract;
class PlanTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Plan $plan)
    {
        return [
            'identifier' => (int)$plan->id,
            'title' => (string)$plan->title,
            'price_month' => $plan->price_month,

            'price_year' => $plan->price_year,
            'currency_id' => $plan->currency_id,
            'plan_level' => $plan->plan_level,
            'no_featured_items' => $plan->no_featured_items,
            'no_sales_transaction' => $plan->no_sales_transaction,
            'no_emp' => $plan->no_emp,
            'no_item' => $plan->no_item,
            'is_trial' => $plan->is_trial,
            'is_support' => $plan->is_support,
            'is_mix_store' => $plan->is_mix_store,

            'creationDate' => (string)$plan->created_at,
            'lastChange' => (string)$plan->updated_at,
            'deletedDate' => isset($plan->deleted_at) ? (string) $plan->deleted_at : null,
            // 'links' => [
            //     [
            //         'rel' => 'self',
            //         'href' => route('plan.show', $plan->id),
            //     ],
            // ]
        ];
    }
    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'title' => 'title',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'title' => 'title',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}