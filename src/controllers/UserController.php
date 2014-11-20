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

        if (Auth::attempt(array('email' => $username, 'password' => $password)))
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

    /**
     * This is handling the user dashboard view.
     */
    public function getUserDashboard()
    {
        $this->layout->pageTitle = 'Welcome to your Dashboard';
        $this->layout->content = View::make('administer::users.user-dashboard');
    }
}