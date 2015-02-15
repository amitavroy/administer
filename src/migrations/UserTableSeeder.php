<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 11/18/14
 * Time: 5:07 PM
 */

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->truncate();
        $userId = $this->createUser();
        $authUserId = $this->createAuthenticatedUserOnly();

        DB::table('groups')->truncate();
        $groupId = $this->createGroup();

        DB::table('user_groups')->truncate();
        $this->addUserGroupRef($userId, $groupId);
        $this->addUserGroupRef($authUserId, 1);

        DB::table('permissions')->truncate();
        DB::table('group_permissions')->truncate();
        $this->handlePermissions();
    }

    private function createUser()
    {
        $user = new AdminUser;
        $user->name = 'Amitav Roy';
        $user->email = 'reachme@amitavroy.com';
        $user->password = Hash::make('pass');
        $user->data = "This is something";
        $user->status = 1;
        $user->save();

        return $user->id;
    }

    private function createAuthenticatedUserOnly()
    {
        $user = new AdminUser;
        $user->name = 'Authenticate user';
        $user->email = 'auth@amitavroy.com';
        $user->password = Hash::make('pass');
        $user->data = "This is something";
        $user->status = 1;
        $user->save();

        return $user->id;
    }

    private function createGroup()
    {
        $group = Groups::create(array(
          'name' => 'Authenticated user',
          'data' => serialize(array('desc' => 'This is the user with just basic access.'))
        ));

        $group = Groups::create(array(
          'name' => 'Super Admin',
          'data' => serialize(array('desc' => 'This is the user group with access to everything.'))
        ));
        $adminId = $group->id;

        $group = Groups::create(array(
          'name' => 'Administrator',
          'data' => serialize(array('desc' => 'This is the user group with privilage access.'))
        ));

        return $adminId;
    }

    private function addUserGroupRef($userId, $groupId)
    {
        UserGroups::create(array(
          'user_id' => $userId,
          'group_id' => 1,
        ));

        if ($groupId != 1) {
            UserGroups::create(array(
              'user_id' => $userId,
              'group_id' => $groupId,
            ));
        }
    }

    private function handlePermissions()
    {
        $groups = DB::table('groups')->get();
        $permissionIds = array();

        $permissionIds[] = DB::table('permissions')->insertGetId(array(
          'permission_name' => 'View all users',
          'permission_machine_name' => 'view_all_users',
          'permission_group' => 'Users',
        ));

        $permissionIds[] = DB::table('permissions')->insertGetId(array(
          'permission_name' => 'Manage all users',
          'permission_machine_name' => 'manage_all_users',
          'permission_group' => 'Users',
        ));

        $permissionIds[] = DB::table('permissions')->insertGetId(array(
          'permission_name' => 'Delete users',
          'permission_machine_name' => 'delete_users',
          'permission_group' => 'Users',
        ));

        foreach ($permissionIds as $id) {
            foreach ($groups as $g) {
                DB::table('group_permissions')->insert(array(
                  'permission_id' => $id,
                  'group_id' => $g->id,
                  'allow' => ($g->id == 2) ? 1 : 0,
                ));
            }
        }
    }

}