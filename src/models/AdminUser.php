<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 11/18/14
 * Time: 4:11 PM
 */

class AdminUser extends Illuminate\Database\Eloquent\Model {

    protected $table = 'users';

    /**
     * This function will return the user groups.
     * @param $userId
     * @param bool $full
     * @return mixed
     */
    public function UserGroups($userId, $full = false)
    {
        /**
         * Checking of the id
         */
        if (!isset($userId) || !is_numeric($userId)) {
            App::abort(500, 'Invalid or missing argument');
        }

        /**
         * Fields we need to select by default
         */
        $select = array(
            'groups.name', 'groups.id'
        );

        /**
         * Need to pass second parameter as true to get full group details
         */
        if ($full == true) {
            array_push($select, 'groups.data', 'groups.created_at', 'groups.updated_at');
        }

        $query = DB::table('user_groups');
        $query->select($select);
        $query->where('user_groups.user_id', $userId);
        $query->join('groups', 'groups.id', '=', 'user_groups.group_id', 'left');
        $result = $query->get();

        /**
         * If group full data required, then un-serialise the data also.
         * Else return the default query result.
         */
        if ($full == true) {
            $data = array();
            foreach ($result as $key => $r) {
                $r->data = unserialize($r->data);
                $data[] = $r;
            }
            return $data;
        } else {
            return $result;
        }
    }
}