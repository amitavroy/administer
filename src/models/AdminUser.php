<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 11/18/14
 * Time: 4:11 PM
 */

class AdminUser extends Illuminate\Database\Eloquent\Model {

    protected $table = 'users';

    protected $fillable = array('name', 'email', 'data', 'status');
    protected $guarded = array('id', 'password');
    
    protected $valMess = array(
        'name.required' => 'We need to know your name.',
        'email.required' => 'Email address is mandatory.',
        'conf_pass.required' => 'Need to type the password twice.',
        'conf_pass.matchpass' => 'The two passwords do not match',
    );

    /**
     * This function will return the user groups.
     * @param $userId
     * @param bool $full
     * @return mixed
     */
    public function UserGroups($userId, $full = false)
    {
        // check if cache present without full
        if ($full == false) {
            $cacheData = AdminHelper::getCache('user_groups_'.$userId);
            if ($cacheData) {
                return $cacheData;
            }
        }

        // check if cache present with full
        if ($full != false) {
            $cacheData = AdminHelper::getCache('user_groups_full'.$userId);
            if ($cacheData) {
                return $cacheData;
            }
        }

        // Validating the user id
        if (!isset($userId) || !is_numeric($userId)) {
            App::abort(500, 'Invalid or missing argument');
        }

        // Fields we need to select by default
        $select = array(
            'groups.name', 'groups.id'
        );

        // Need to pass second parameter as true to get full group details
        if ($full == true) {
            array_push($select, 'groups.data', 'groups.created_at', 'groups.updated_at');
        }

        $query = DB::table('user_groups');
        $query->select($select);
        $query->where('user_groups.user_id', $userId);
        $query->join('groups', 'groups.id', '=', 'user_groups.group_id', 'left');
        $query->orderBy('groups.id', 'desc');
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
            Cache::forever('user_groups_full_'.$userId, $data);
            return $data;
        } else {
            Cache::forever('user_groups_'.$userId, $result);
            return $result;
        }
    }

    /**
     * This function is updating the profile once the validation is passed.
     * @param $postData
     */
    public function profileUpdate($postData)
    {
        try {
            DB::beginTransaction();
            $user = User::find(Auth::user()->id);
            $user->email = $postData['email'];
            $user->name = $postData['name'];

            // check current password is correct if isset
            if ($postData['current_pass'] != '') {

                $credentials = array(
                  'email' => Auth::user()->email,
                  'password' => $postData['current_pass']
                );

                if (!Auth::validate($credentials)) {
                    AdminHelper::setMessages('Current password is wrong', 'danger');
                    return Redirect::to('user/profile/edit');
                }
                $user->password = Hash::make($postData['new_pass']);
            }

            $user->save();

            $this->saveUserGroupMapping(1, $postData['groups']);

            DB::commit();

            Event::fire('auth.update');
        } catch (Exception $e) {
            DB::rollback();
            App::abort(500, 'DB Transaction failed. Data not saved');
        }
    }

    /*
     * This function is validating the form of edit profile
     * and returning the validator object.
     */
    public function profileUpdateValidation($data)
    {
        /*
         * Setting rules for the form
         */
        $rules = array(
            'name' => 'required|min:3',
            'email' => 'required|email',
        );

        if ($data['current_pass'] != '') {
            $rules['new_pass'] = 'required';
            $rules['conf_pass'] = 'required|Matchpass:' . $data['new_pass'];
        }

        $messages = array(
            'name.required' => $this->valMess['name.required'],
            'email.required' => $this->valMess['email.required'],
            'new_pass.required' => 'Provide a password to change.',
            'conf_pass.required' => $this->valMess['conf_pass.required'],
            'conf_pass.matchpass' => $this->valMess['conf_pass.matchpass'],
        );

        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    /**
     * This function is first removing all the user group assignment
     * and then inserting the new ones.
     * @param $uid
     * @param $groupIds
     */
    private function saveUserGroupMapping($uid, $groupIds)
    {
        UserGroups::where('user_id', $uid)->delete();

        foreach ($groupIds as $id) {
            $userGroup = new UserGroups;
            $userGroup->user_id = $uid;
            $userGroup->group_id = $id;
            $userGroup->save();
        }

        $userGroup = new UserGroups;
        $userGroup->user_id = $uid;
        $userGroup->group_id = 1;
        $userGroup->save();
    }

    /**
     * Validating the data before creating user.
     * @param  $data
     * @return true / false
     */
    public function createUserValidation($data)
    {
        /*
         * Setting rules for the form
         */
        $rules = array(
            'name' => 'required|min:3',
            'email' => 'required|email',
            'email' => 'unique:users,email',
            'new_pass' => 'required',
            'conf_pass' => 'required|Matchpass:' . $data['new_pass'],
        );

        $messages = array(
            'name.required' => $this->valMess['name.required'],
            'email.required' => $this->valMess['email.required'],
            'new_pass.required' => 'You need a password to create account.',
            'conf_pass.required' => $this->valMess['conf_pass.required'],
            'conf_pass.matchpass' => $this->valMess['conf_pass.matchpass'],
        );

        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    public function createNewUser($data)
    {
        try {
            DB::beginTransaction();

            $user = new AdminUser;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->status = 1;
            $user->save();
            
            $userId = $user->id;
            
            foreach ($data['groups'] as $key => $groupId) {
                $groups[$key] = $groupId;
            }

            $groups[count($groups)] = 1;

            $userGroups = array();
            foreach ($groups as $key => $groupId) {
                $userGroups[$key] = array('group_id' => $groupId, 'user_id' => $userId);
            }

            DB::table('user_groups')->insert($userGroups);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            App::abort(500, 'DB Transaction failed. Data not saved');
        }
    }

    public function deleteUser($id)
    {
        if ($id == 1) {
            AdminHelper::setMessages('This user cannot be deleted.', 'warning');
            return false;
        }
        else {
            DB::table($this->table)->where('id', $id)->delete();
            AdminHelper::setMessages('The user was deleted.', 'success');
            return true;
        }
    }
}