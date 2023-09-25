<?php

declare(strict_types=1);

namespace ImiApp\Module\Test\WebSocketController;

use Imi\Aop\Annotation\Inject;
use Imi\Log\Log;
use Imi\Server\WebSocket\Controller\WebSocketController;
use Imi\Server\WebSocket\Route\Annotation\WSAction;
use Imi\Server\WebSocket\Route\Annotation\WSController;
use Imi\Server\WebSocket\Route\Annotation\WSRoute;
use ImiApp\Module\Test\Service\TestService;

/**
 * 数据收发测试.
 *
 * @WSController
 */
class TestController extends WebSocketController
{
    /**
     * @Inject
     */
    protected TestService $testService;

    /**
     * @WSAction
     * @WSRoute({"action"="start"})
     *
     * @param mixed $data
     */
    public function start($data): array
    {
        try
        {
            $this->testService->start($this->frame->getClientId());

            return [
                'code'    => 0,
                'message' => '',
            ];
        }
        catch (\Throwable $th)
        {
            Log::error($th);

            return [
                'code'    => 500,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * @WSAction
     * @WSRoute({"action"="stop"})
     *
     * @param mixed $data
     */
    public function stop($data): array
    {
        try
        {
            $this->testService->stop($this->frame->getClientId());

            return [
                'code'    => 0,
                'message' => '',
            ];
        }
        catch (\Throwable $th)
        {
            Log::error($th);

            return [
                'code'    => 500,
                'message' => $th->getMessage(),
            ];
        }
    }
}
