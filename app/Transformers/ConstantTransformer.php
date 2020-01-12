<?php
namespace App\Transformers;
use App\Constant;
use League\Fractal\TransformerAbstract;
class ConstantTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Constant $constant)
    {
        return [
            'identifier' => (int)$constant->id,
            'name' => (string)$constant->name,
            'creationDate' => (string)$constant->created_at,
            'lastChange' => (string)$constant->updated_at,
            'deletedDate' => isset($constant->deleted_at) ? (string) $constant->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('constants.show', $constant->id),
                ],
            ]
        ];
    }
    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
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
            'name' => 'name',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}