<?php

declare(strict_types=1);

namespace ImiApp\Module\Test\Listener;

use Imi\Aop\Annotation\Inject;
use Imi\Bean\Annotation\ClassEventListener;
use Imi\Swoole\Server\Event\Listener\ICloseEventListener;
use Imi\Swoole\Server\Event\Param\CloseEventParam;
use ImiApp\Module\Test\Service\TestService;

/**
 * @ClassEventListener(className="Imi\Swoole\Server\WebSocket\Server", eventName="close")
 */
class OnClose implements ICloseEventListener
{
    /**
     * @Inject
     */
    protected TestService $testService;

    /**
     * 事件处理方法.
     */
    public function handle(CloseEventParam $e): void
    {
        $this->testService->stop($e->clientId);
    }
}
