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
            return Redirect::intended('users/dashboard');
        }
        else
        {
            AdminHelper::setMessages('Login failed!', 'warning');
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
            return Redirect::to('users/profile/edit')->withInput()->withErrors($validator);
        } else {
            $user->profileUpdate($postData);

            AdminHelper::setMessages('Profile updated', 'success');
            return Redirect::to('users/profile/view');
        }
    }

    public function getUserAddPage()
    {
        $user = new AdminUser;

        $data = array(
          'groups' => $user->UserGroups(Auth::user()->id),
          'all_groups' => Groups::getAllGroups()
        );

        $this->layout->pageTitle = 'Add new user';
        $this->layout->content = View::make('administer::users.add-user')
            ->with('data', $data);
    }

    public function handleUserSave()
    {
        $postData = Input::all();

        $user = new AdminUser;

        $validator = $user->createUserValidation($postData);

        if ($validator->fails()) {
            AdminHelper::setMessages('Validation failed!', 'warning');
            return Redirect::to('users/add')->withInput()->withErrors($validator);
        } else {
            $user->createNewUser(array(
                'name' => $postData['name'],
                'email' => $postData['email'],
                'password' => $postData['conf_pass'],
            ));

            AdminHelper::setMessages('New user created', 'success');
            return Redirect::to('users/view');
        }
    }

    public function getUserListing()
    {
        Permissions::pageAccess('manage_all_users');
        
        $user = new AdminUser;
        $users = DB::table('users')->paginate(20);

        $this->layout->pageTitle = 'View all users';
        $this->layout->content = View::make('administer::users.view-users')
            ->with('users', $users);
    }

    public function handleDeleteUser($id)
    {
        Permissions::pageAccess('delete_users');

        $user = new AdminUser;

        $user->deleteUser($id);

        return Redirect::to('users/view');
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