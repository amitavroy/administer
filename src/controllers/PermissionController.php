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
        Permissions::pageAccess('manage_permissions');

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

        if ($permissions->handlePermissionMatrixUpdate($postData)) {
            AdminHelper::setMessages('Saved');
        }

        return Redirect::back();
    }

    public function handleAddPermission()
    {
        $permissionData = Permissions::all();
        
        $this->layout->pageTitle = 'Add new permission';
        $this->layout->content = View::make('administer::permissions.permission-add')
            ->with('permissions', $permissionData);
    }

    public function handlePermissionAdd()
    {
        $permission = new Permissions;

        $permission->addNewPermission(Input::get('permision'));

        return Redirect::back();
    }
}