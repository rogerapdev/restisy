<?php namespace App\Transformers;

class RoleTransformer extends Transformer
{
    public function transform($role)
    {
        return [
            'slug' => $role->slug,
            'name' => $role->name
        ];
    }

}
