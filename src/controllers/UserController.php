<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 11/18/14
 * Time: 5:37 PM
 */

class UserController extends GlobalController {

    /**
     * This is handling the login page view.
     */
    public function getUserLoginPage()
    {
        $this->layout->pageTitle = 'Login';
        $this->layout->content = View::make('administer::users.login');
    }

    /**
     * This function is handling the user authentication.
     */
    public function handleUserLogin()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        if (Auth::attempt(array('email' => $username, 'password' => $password, 'status' => 1)))
        {
            /**
             * session is handled through event
             * and then return user to the url
             */
            return Redirect::intended('user/dashboard');
        }
        else
        {
            return Redirect::to('login');
        }
    }

    /**
     * Handle the logout of the user.
     */
    public function handleUserLogout()
    {
        Auth::logout();
        return Redirect::to('login');
    }

    public function getUserProfileView()
    {
        $user = new AdminUser;

        $data = array(
          'groups' => $user->UserGroups(Auth::user()->id),
        );
        $this->layout->pageTitle = 'Your profile';
        $this->layout->content = View::make('administer::users.view-profile')
          ->with('data', $data);
    }

    /*
     * Handle the view profile page.
     */
    public function getUserProfileEdit()
    {
        $user = new AdminUser;

        $data = array(
          'groups' => $user->UserGroups(Auth::user()->id),
          'all_groups' => Groups::getAllGroups()
        );
        $this->layout->pageTitle = 'Your profile';
        $this->layout->content = View::make('administer::users.edit-profile')
          ->with('data', $data);
    }

    public function handleUserProfileUpdate()
    {
        $postData = Input::all();//AdminHelper::dsm($postData,1);

        $user = new AdminUser;

        $validator = $user->profileUpdateValidation($postData);

        if ($validator->fails()) {
            AdminHelper::setMessages('Validation failed!', 'warning');
            return Redirect::to('user/profile/edit')->withInput()->withErrors($validator);
        } else {
            $user->profileUpdate($postData);

            AdminHelper::setMessages('Profile updated', 'success');
            return Redirect::to('user/profile/view');
        }
    }

    /**
     * This is handling the user dashboard view.
     */
    public function getUserDashboard()
    {
        $this->layout->pageTitle = 'Welcome ' . Auth::user()->name;
        $this->layout->content = View::make('administer::users.user-dashboard');
    }
}