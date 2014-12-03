<?php
/**
 * Created by PhpStorm.
 * User: amitav
 * Date: 27/11/14
 * Time: 12:00 PM
 */

class Permissions extends Illuminate\Database\Eloquent\Model {

    protected $table = 'permissions';

    /**
     * This function will check if the user has access to that particular function
     *
     * @param $permission_name
     *
     * @return bool
     */
    public static function checkAccess($permission_name)
    {
        // get current user id
        $userId = Auth::user()->id;

        // get the user groups
        $AdminUser = new AdminUser;
        $userGroups = $AdminUser->UserGroups($userId);

        // check if the user is admin, then no need to check access
        foreach ($userGroups as $group) {
            if ($group->id == 2) {
                return true;
            }
        }

        // get the permission id and group ids with allow or not
        $permission = Permissions::where('permission_machine_name', '=', $permission_name)
            ->join('group_permissions', 'group_permissions.permission_id', '=', 'permissions.permission_id')
            ->get();

        // check if the group is present and then the allow flag
        foreach ($permission as $p) {
            foreach ($userGroups as $group) {
                // first check if user group is present in the permission list group
                // then check if allowed is 0 or 1
                if ($group->id == $p->group_id && $p->allow == 1) {
                    return true;
                }
            }
        }

        // if not, then return false
        return false;
    }

    public static function pageAccess($permission_name)
    {
        if (!Permissions::checkAccess($permission_name)) {
            header('Location: ' . url('access-denied'));die;
        }
    }
}
