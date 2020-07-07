<?php namespace App\Transformers;

use Hasher;

class TypeTransformer extends Transformer
{
    public function transform($type)
    {
        return [
            'id' => Hasher::encode($type->id),
            'slug' => $type->slug,
            'group' => $type->group,
            'name' => $type->name
        ];
    }

}
