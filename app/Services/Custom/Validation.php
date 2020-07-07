<?php
namespace App\Services\Custom;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator as IlluminateValidator;

class Validation extends IlluminateValidator
{


     /**
     * Valida CPF
     * @param string $attribute
     * @param string $value
     * @return boolean
     */

    protected function validateCpf($attribute, $value)
    {
        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) ;

        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) ;

        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;

    }

    /**
     * Valida CNPJ
     * @param string $attribute
     * @param string $value
     * @return boolean
     */
    protected function validateCnpj($attribute, $value)
    {
        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) != 14 || preg_match("/^{$c[0]}{14}$/", $c)) {
            return false;
        }

        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]) ;

        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]) ;

        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;

    }

    /**
     * Valida CNPJ ou CPF
     * @param string $attribute
     * @param string $value
     * @return boolean
     */
    protected function validateCpfCnpj($attribute, $value)
    {
        return ($this->validateCpf($attribute, $value) || $this->validateCnpj($attribute, $value));
    }


    public function validateIntegerEmpty($attribute, $value, $parameters)
    {
        return !empty($value) ? (filter_var(intval($value), FILTER_VALIDATE_INT) !== false) : true;
    }

    public function validateRequiredNotEmpty($attribute, $value, $parameters)
    {

        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && trim($value) === '') {
            return false;
        } elseif ((is_array($value) || $value instanceof Countable) && count($value) < 1) {
            return false;
        } elseif ($value instanceof File) {
            return (string) $value->getPath() !== '';
        }

        if (is_numeric($value)) {
            $value = floatval($value);
        }

        return !empty($value);
    }


    public function validateMask($attribute, $value, $parameters)
    {

        $mask = array_shift($parameters);

        return strlen($value) == strlen($mask);

    }

    //Custom Replacers
    /**
     * The replacer that goes with my specific custom validator. They
     * should be named the same with a different prefix word so laravel
     * knows they should be run together.
     */
    protected function replaceMask($message, $attribute, $rule, $parameters)
    {
        //All custom placeholders that live in the message for
        //this rule should live in the first parameter of str_replace
        return str_replace([':format'], array_shift($parameters), $message);
    }

}
