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

    /**
     * This is the global function to call all cache objects.
     * If the config of caching is disabled, it will always return false
     * and hence no caching. (Should not be true for production until required.)
     * @param $cacheKey
     * @return bool
     */
    public static function getCache($cacheKey)
    {
        $caching = AdminHelper::getConfig('caching');

        if (!$caching) {
            return false;
        }
        else {
            $cacheData = Cache::get($cacheKey);
            if (!$cacheData) {
                return false;
            } else {
                return $cacheData;
            }
        }
    }

    /**
     * This function will check the current route and apply the active or
     * normal class.
     *
     * @param $link
     * @return string
     */
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

    /**
     * This function is compiling all the messages in the session in a key value
     * pair. It sets messages based on different alert levels.
     * @param $message
     * @param string $flag
     */
    public static function setMessages($message, $flag = 'info')
    {
        if (!Session::get('messages')) {
            $messageArr = array(
              'success' => '',
              'info' => '',
              'warning' => '',
              'danger' => '',
            );
        } else {
            $messageArr = Session::get('messages');
        }


        $messageArr[$flag] = $messageArr[$flag] .
          "<div class='alert alert-{$flag}' role='alert'>{$message}</div>";

        Session::put('messages', $messageArr);
    }

    /**
     * This function is going to fetch all messages set throughout the applicaiton
     * and render them out.
     * It will also clear the session once the messages are displayed.
     * @return string
     */
    public static function getMessages()
    {
        $sessionMessages = Session::get('messages');

        $output = '';
        foreach ($sessionMessages as $message) {
            if ($message != '')
                $output .= $message;
        }

        $messageArr = array(
          'success' => '',
          'info' => '',
          'warning' => '',
          'danger' => '',
        );

        Session::put('messages', $messageArr);

        return $output;
    }

    public static function getUserGroupStatus($groupName, $groupObject)
    {
        if ($groupName == 'Authenticated user') {
            return true;
        }

        foreach ($groupObject as $g) {
            if (strtolower($g->name) == strtolower($groupName)) {
                return true;
            }
        }
    }
}