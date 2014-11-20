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
        
    }

    public function subscribe($events)
    {
        $events->listen('auth.login', 'EventManager@onUserLogin');
    }
}