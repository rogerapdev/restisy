<?php
namespace App\Helpers;

use Hashids\Hashids;

class Hasher
{
    public static function encode(...$args)
    {
        $hashid = new Hashids(env('HASHIDS_SALT'), env('HASHIDS_LENGTH'));

        return $hashid->encode(...$args);
    }

    public static function decode($enc)
    {

        $hashid = new Hashids(env('HASHIDS_SALT'), env('HASHIDS_LENGTH'));
        $dec = $hashid->decode($enc);

        return count($dec) ? $dec[0] : $enc;
    }
}
