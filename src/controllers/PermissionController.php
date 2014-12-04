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
        $permissions = Permissions::get();
        $groups = Groups::get();
        $groupPermissions = DB::table('group_permissions')->get();

        $this->layout->pageTitle = 'Manage permissions';
        $this->layout->content = View::make('administer::permissions.permission-manage')
            ->with('groups', $groups)
            ->with('groupPermissions', $groupPermissions)
            ->with('permissions', $permissions);
    }

    public function handlePermissionSave()
    {
        AdminHelper::dsm(Input::all(), 1);
    }
}