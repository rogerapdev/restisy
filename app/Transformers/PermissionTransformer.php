<?php namespace App\Transformers;

class PermissionTransformer extends Transformer
{
    public function transform($permission)
    {
        return [
            'action' => $permission->action,
            'name' => $permission->name,
            'description' => $permission->description,
            'resource' => (new ResourceTransformer)->transform($permission->resource)
        ];
    }

}
