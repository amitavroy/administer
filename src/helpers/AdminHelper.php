<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 11/18/14
 * Time: 4:16 PM
 */

class AdminHelper {

    public  static function dsm($var = null, $flag = 0)
    {
        if ($var == null)
            App::abort(500, 'First argument is missing');

        echo '<pre>';
        print_r($var);
        echo '</pre>';

        if ($flag == 1)
            exit;
    }

    public static function getConfig($name = null)
    {
        if ($name == null)
            App::abort(500, 'Configuration name is missing');

        return Config::get("packages/amitavroy/administer/administer.{$name}");
    }
}