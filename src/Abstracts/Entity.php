<?php

namespace Reworker\Abstracts;

abstract class Entity
{
    protected array $response;

    protected function runCallBack(?string $callback_class = null): void
    {
        if(!is_null($callback_class)) {
            $callback = new $callback_class($this->response);
            $callback->run();
        }
    }

    public function getResponse(?string $callback_class = null): ?array
    {
        $this->runCallBack($callback_class);
        return $this->response ?? null;
    }

}