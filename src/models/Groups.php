<?php
/**
 * Created by PhpStorm.
 * User: amitav
 * Date: 20/11/14
 * Time: 10:08 AM
 */

class Groups extends Eloquent {
    protected $table = 'groups';

    public static function getAllGroups()
    {
        $cacheData = AdminHelper::getCache('all_groups');
        if ($cacheData) {
            return $cacheData;
        }

        $query = Groups::all();

        $data = array();

        foreach ($query as $key => $group) {
            $data[$key] = array(
                'id' => $group->id,
                'name' => $group->name,
                'data' => unserialize($group->data)
            );
        }

        Cache::forever('all_groups', $data);

        return $data;
    }
}