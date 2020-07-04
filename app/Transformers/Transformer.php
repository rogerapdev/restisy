<?php namespace App\Transformers;

abstract class Transformer
{
    /**
     * Transform a collection.
     *
     * @param $items
     * @return array
     */
    public function transformCollection($collection)
    {
        return $collection->map(function ($item, $key) {
            return $this->transform($item);
        });
    }

    abstract public function transform($item);
}
