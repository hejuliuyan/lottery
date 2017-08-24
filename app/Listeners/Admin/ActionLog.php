<?php

namespace App\Listeners\Admin;

use App\Events\Admin\ActionLog as EventsActionLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Admin\ActionLog as ActionLogModel;
use Request;

class ActionLog
{
    private $model;

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new ActionLogModel();
    }

    /**
     * Handle the event.
     *
     * @param  EventsActionLog  $event
     * @return void
     */
    public function handle(EventsActionLog $event)
    {
        $addDatas['username'] = $event->userName;
        $addDatas['user_id'] = $event->userId;
        $addDatas['ip'] = Request::ip();
        $addDatas['ip_adress'] = '';
        $addDatas['add_time'] = time();
        $addDatas['realname'] = $event->realName;
        $addDatas['content'] = $event->message;
        $this->model->add($addDatas);
    }
}
