<?php

namespace App\Helpers;

class DBHelper
{
    public static function getSqlQuery($q, $values)
    {
        if (!empty($values)) {
            return self::includeBindings($q->getSql(), $values);
        }
        return $q->getSql();
    }

    public static function includeBindings($query, $bindings)
    {
        if (!is_array(reset($bindings))) {
            foreach ($bindings as $key => $value) {
                $query = str_replace($key, !is_integer($value) ? "'".$value."'" : $value, $query);
            }
        } else {
            foreach ($bindings as $key => $array) {
                $query = str_replace($key, self::formatValues($array), $query);
            }
        }

        return $query;
    }

    public static function prepare($builder, $query)
    {
        $builder->writeFormatted($query);
        return self::getSqlQuery($query, $builder->getValues());
    }

    public static function formatValues($array)
    {
        $prefix = $list = '';
        foreach ($array as $key => $value)
        {
            $val = !is_integer($value) ?  "'" . $value . "'" : $value;
            $list .= $prefix . $val;
            $prefix = ', ';
        }
        return $list;
    }
}