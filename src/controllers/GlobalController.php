<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 11/18/14
 * Time: 5:37 PM
 */

class GlobalController extends BaseController {
    protected $layout;

    public function __construct()
    {
        $this->setLayout(AdminHelper::getConfig('master-layout'));
    }

    public function setLayout($layoutName = null)
    {
        if ($layoutName == null)
            App::abort(500, 'Layout path not provided');

        $this->layout = $layoutName;
    }
}