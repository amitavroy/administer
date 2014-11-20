<?php
/**
 * Created by PhpStorm.
 * User: amitav
 * Date: 20/11/14
 * Time: 4:21 PM
 */

class AdminUserModelTest extends TestCase {

    public function __construct()
    {
        $this->user = new AdminUser;
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\HttpException
     * @expectedExceptionMessage Invalid or missing argument
     */
    public function testUSerGroupWithoutId()
    {
        $this->user->UserGroups('a');
    }

    public function testGroupDetailsHasData()
    {
        $user = $this->user->UserGroups(1, true);
        $this->assertObjectHasAttribute('data', $user[0]);
    }

    public function testGroupDetailsHasNoData()
    {
        $user = $this->user->UserGroups(1);
        $this->assertObjectNotHasAttribute('data', $user[0]);
    }
}