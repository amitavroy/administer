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
        // check if cache present without full
        if ($full == false) {
            $cacheData = Cache::get('user_groups_'.$userId);
            if ($cacheData) {
                return $cacheData;
            }
        }

        // check if cache present with full
        if ($full != false) {
            $cacheData = Cache::get('user_groups_full'.$userId);
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
    }

    /*
     * This function is validating the form of edit profile
     * and returning the validator object.
     */
    public function profileUpdateValidation($postData)
    {
        /*
         * Setting rules for the form
         */
        $rules = array(
          'name' => 'required|min:3',
          'email' => 'required|email',
        );

        if ($postData['current_pass'] != '') {
            $rules['new_pass'] = 'required';
            $rules['conf_pass'] = 'required|Matchpass:' . $postData['new_pass'];
        }

        $messages = array(
          'name.required' => 'We need to know your name.',
          'email.required' => 'Email address is mandatory.',
          'new_pass.required' => 'Provide a password to change.',
          'conf_pass.required' => 'Need to type the password twice.',
          'conf_pass.matchpass' => 'The two passwords do not match',
        );

        $validator = Validator::make($postData, $rules, $messages);

        return $validator;
    }
}