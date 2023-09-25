<?php

declare(strict_types=1);

namespace ImiApp\Module\Test\ApiController;

use Imi\Aop\Annotation\Inject;
use Imi\Log\Log;
use Imi\Server\Http\Controller\HttpController;
use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use ImiApp\Module\Test\Service\TestService;

/**
 * @Controller("/")
 */
class IndexController extends HttpController
{
    /**
     * @Inject
     */
    protected TestService $testService;

    /**
     * @Action
     *
     * @return array
     */
    public function api()
    {
        Log::info('/api', [], 'request');

        return [
            'data'  => 'api',
        ];
    }
}
