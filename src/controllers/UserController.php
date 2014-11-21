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

    public function getUserProfileView()
    {
        $this->layout->pageTitle = 'Your profile';
        $this->layout->content = View::make('administer::users.view-profile');
    }

    /*
     * Handle the view profile page.
     */
    public function getUserProfileEdit()
    {
        $this->layout->pageTitle = 'Your profile';
        $this->layout->content = View::make('administer::users.edit-profile');
    }

    public function handleUserProfileUpdate()
    {
        $postData = Input::all();

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

        if ($validator->fails()) {
            return Redirect::to('user/profile/edit')->withInput()->withErrors($validator);
        } else {
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
                    App::abort(500, 'Current password is not correct');
                }
                $user->password = Hash::make($postData['new_pass']);
            }

            $user->save();

            return Redirect::to('user/dashboard');
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