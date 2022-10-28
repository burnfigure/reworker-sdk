<?php

namespace Reworker\Interfaces;

interface EntityInterface
{
    public function getResponse(?string $callback_class = null): ?array;
}