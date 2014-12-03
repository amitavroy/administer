<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 3/12/14
 * Time: 11:53 AM
 */

class PermissionController extends GlobalController {

    public function handleManagePermissions()
    {
        $this->layout->pageTitle = 'Manage permissions';
    }
}