<?php namespace App\Transformers;

class ResourceTransformer extends Transformer
{
    public function transform($resource)
    {
        return [
            'slug' => $resource->slug,
            'name' => $resource->name
        ];
    }

}
