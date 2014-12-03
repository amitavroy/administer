<?php
/**
 * Created by PhpStorm.
 * User: amitav
 * Date: 2/12/14
 * Time: 9:47 AM
 */

class GroupsController extends GlobalController {

    public function handleManageGroups()
    {
        $this->layout->pageTitle = 'Manage Groups';
        if (Permissions::checkAccess('view_all_users')) {
            AdminHelper::dsm('Has access');
        } else {
            AdminHelper::dsm('Access denied');
        }
    }
}