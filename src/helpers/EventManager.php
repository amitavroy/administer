<?php
/**
 * Created by PhpStorm.
 * User: amitav
 * Date: 20/11/14
 * Time: 1:37 PM
 */

class EventManager {

    public function onUserLogin()
    {
        // login success message
        AdminHelper::setMessages('Login successful', 'success');

        // setting the user time zone
        date_default_timezone_set(Auth::user()->timezone);
    }

    public function subscribe($events)
    {
        $events->listen('auth.login', 'EventManager@onUserLogin');
    }
}