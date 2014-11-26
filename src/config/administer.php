<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 11/18/14
 * Time: 5:38 PM
 */

return array(
    /**
     * This setting is to handle the caching on the application.
     * All cache get is done through global function and hence if
     * turned false, all queries will start to execute on every page.
     */
    'caching' => true,
    /**
     * This is the main application title which will come by default
     * if the page title is not set.
     */
    'app-title' => 'Administer',
    /**
     * This is the main layout which will be used for the admin interface
     * of the application.
     */
    'master-layout' => 'administer::masters.html',
);