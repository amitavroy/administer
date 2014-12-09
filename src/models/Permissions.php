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

    /**
     * This function should be called on a controller level to check if a user
     * has access to a particular page or not.
     * It will redirect to access denied page, if the user does not have permission.
     *
     * @param $permission_name
     */
    public static function pageAccess($permission_name)
    {
        if (!Permissions::checkAccess($permission_name)) {
            header('Location: ' . url('access-denied'));die;
        }
    }

    /**
     * This function will query the database to fetch the permissions, groups
     * and the group vs permission mapping and format the data in desired format
     * based on which the permission matrix table is generated and managed.
     * @return mixed
     */
    public function formatPermissionMatrix()
    {
        // setting permissions
        $permissions = Permissions::get()->toArray();
        $perm_final = array();
        foreach ($permissions as $permission) {
            $perm_final[$permission['permission_id']] = $permission;
        }

        // setting groups
        $groups = Groups::orderBy('id', 'asc')->get()->toArray();
        $group_final = array();
        foreach ($groups as $group) {
            $group_final[$group['id']] = $group;
        }

        // setting group permissions
        $gp = DB::table('group_permissions')
          ->join('groups', 'groups.id', '=', 'group_permissions.group_id')
          ->get();

        $final_perm_map = array();
        foreach ($gp as $key => $value) {
            $final_perm_map[$value->permission_id][] = $value;
        }

        $data['permissions'] = $perm_final;
        $data['groups'] = $group_final;
        $data['gp'] = $gp;

        return $data;
    }

    /**
     * This function is called by the controller and passed the post data.
     * It will internally call the private function to get the value, and update
     * the group_permission table with the new permission set.
     *
     * @param $postData
     * @return bool
     */
    public function handlePermissionMatrixUpdate($postData)
    {
        foreach ($postData as $key => $value) {
            $arrayCheck = explode('|', $key);
            // get only the hidden values
            if (count($arrayCheck) == 3) {
                $allow = $this->getPermissionValue($arrayCheck, $postData);
                $permissionId = $arrayCheck[0];
                $groupId = $arrayCheck[1];

                DB::table('group_permissions')
                  ->where('permission_id', $permissionId)
                  ->where('group_id', $groupId)
                  ->update(array(
                    'allow' => $allow
                  ));
            }
        }

        return true;
    }

    /**
     * This function will get the array from the hidden filed, post data
     * and then check what will be the new value to save for the group and permission
     * in the permission matrix.
     * @param $arrayCheck
     * @param $postData
     * @return int
     */
    private function getPermissionValue($arrayCheck, $postData)
    {
        $keyCheck = "{$arrayCheck[0]}|{$arrayCheck[1]}";

        if (array_key_exists($keyCheck, $postData)) {
            return 1;
        }
        else {
            return 0;
        }
    }
}
