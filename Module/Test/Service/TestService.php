<?php

declare(strict_types=1);

namespace ImiApp\Module\Test\Service;

use ErrorException;
use Imi\Server\Server;
use Imi\Swoole\Util\Coroutine;

class TestService
{
    protected array $map = [];

    public function getImi(): string
    {
        return 'imi';
    }

    public function start(int $clientId): void
    {
        $fileName = \dirname(__DIR__, 3) . '/.runtime/logs/request.log';
        if (!is_file($fileName))
        {
            file_put_contents($fileName, '', \FILE_APPEND | \LOCK_EX);
        }
        $fp = fopen($fileName, 'r');
        if (false === $fp)
        {
            throw new ErrorException('打开日志文件失败');
        }
        $cid = imigo(function () use ($clientId, $fp) {
            try
            {
                Coroutine::yield();

                $count = 0;
                $list = [];
                $cid = Coroutine::getCid();
                while (isset($this->map[$clientId][$cid]))
                {
                    while (false !== ($str = fgets($fp)))
                    {
                        if (!isset($this->map[$clientId][$cid]))
                        {
                            return;
                        }
                        $str = trim($str);
                        if ('' === $str)
                        {
                            continue;
                        }
                        if (!mb_check_encoding($str, 'UTF-8'))
                        {
                            $str = '【乱码数据】';
                        }
                        $list[] = $str;
                        if (++$count >= 1000)
                        {
                            $request = [
                                'list' => $list,
                            ];
                            if (!Server::send($request, $clientId, 'main', false))
                            {
                                Server::close($clientId, 'main', false);

                                return;
                            }
                            $list = [];
                            $count = 0;
                        }
                    }
                    if ($list)
                    {
                        $request = [
                            'list' => $list,
                        ];
                        if (!Server::send($request, $clientId, 'main', false))
                        {
                            Server::close($clientId, 'main', false);

                            return;
                        }
                        $list = [];
                        $count = 0;
                    }
                    sleep(1);
                    fseek($fp, 0, \SEEK_CUR);
                }
            }
            finally
            {
                $this->stop($clientId);
                fclose($fp);
            }
        });
        $this->map[$clientId][$cid] = true;
        Coroutine::defer(static function () use ($cid) {
            Coroutine::resume($cid);
        });
    }

    public function stop(int $clientId): void
    {
        if (!isset($this->map[$clientId]))
        {
            return;
        }
        $data = $this->map[$clientId];
        unset($this->map[$clientId]);
        foreach ($data as $cid => $_)
        {
            Coroutine::cancel($cid);
        }
        unset($this->map[$clientId]);
    }
}
