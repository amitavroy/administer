<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 11/18/14
 * Time: 5:37 PM
 */

class GlobalController extends BaseController {
    protected $layout;
    protected $events;

    public function __construct()
    {
        $this->setLayout(AdminHelper::getConfig('master-layout'));

        /**
         * Subscribing to the Events handled by the event manager.
         */
        $this->events = new EventManager;
        Event::subscribe($this->events);
    }

    public function setLayout($layoutName = null)
    {
        if ($layoutName == null)
            App::abort(500, 'Layout path not provided');

        $this->layout = $layoutName;
    }

    public function handleAccessDenied()
    {
        $this->layout->pageTitle = 'Access denied!';
        AdminHelper::setMessages('Access denied!', 'warning');
        $this->layout->content = View::make('administer::masters.access-denied');
    }
}