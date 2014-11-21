<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 11/18/14
 * Time: 4:16 PM
 */

class AdminHelper {

    /**
     * This function will var dump the variable which is passed
     * if second parameter true, it will then exit
     * @param null $var
     * @param int $flag
     */
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

    /*
     * This function will take the name of the config and look for the same
     * in the packages folder and pass the value
     */
    public static function getConfig($name = null)
    {
        if ($name == null)
            App::abort(500, 'Configuration name is missing');

        return Config::get("packages/amitavroy/administer/administer.{$name}");
    }

    public static function activeLinkHandle($link)
    {
        if (!isset($link) || $link == '') {
            App::abort(500, 'Link is required');
        }

        $currentRoute = Route::getCurrentRoute()->getPath();

        if ($link == $currentRoute) {
            return 'active';
        } else {
            return 'normal';
        }
    }
}