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
        $perm = new Permissions;
        $data = $perm->formatPermissionMatrix();

        $this->layout->pageTitle = 'Manage permissions';
        $this->layout->content = View::make('administer::permissions.permission-manage')
          ->with('data', $data);
    }

    public function handlePermissionSave()
    {
        $postData = Input::all();
        $permissions = new Permissions;

        if ($permissions->formatPermissionMatrix($postData)) {
            AdminHelper::setMessages('Saved');
        }

        return Redirect::back();
    }

    public function handleAddPermission()
    {
        $this->layout->pageTitle = 'Add new permission';
        $this->layout->content = View::make('administer::permissions.permission-add');
    }
}