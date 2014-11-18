<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 11/18/14
 * Time: 4:23 PM
 */

class AdminHelperTest extends TestCase {

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\HttpException
     * @expectedExceptionMessage First argument is missing
     */
    public function testDsmWitoutVariable()
    {
        $this->assertTrue(AdminHelper::dsm());
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\HttpException
     * @expectedExceptionMessage Configuration name is missing
     */
    public function testGetConfigWithoutName()
    {
        AdminHelper::getConfig();
    }

    public function testGetConfigReturnsCorrectValue()
    {
        $masterConfig = Config::get("packages/amitavroy/administer/administer.master-layout");
        $fromConfig = AdminHelper::getConfig('master-layout');
        $this->assertEquals($masterConfig, $fromConfig);
    }

}