<?php

namespace Reworker\Traits;

use Reworker\Handlers\Filters;
use Reworker\Handlers\ListMaker;

trait MovementsTrait
{
    public function createMovement(int $warehouse_id, string $type, ?string $callback_class = null): ?array
    {
        $this->response = $this->reworker->post(self::PATH, [
            'warehouse' => $warehouse_id,
            'type' => $type
        ]);

        return $this->getResponse($callback_class);
    }

    public function addMovementData(array $data, int $movement_id, ?string $callback_class = null): ?array
    {
        $this->response = $this->reworker->post(self::PATH."/{$movement_id}", $data);
        return $this->getResponse($callback_class);
    }

    public function getMovementItems(int $movement_id, ?string $callback_class = null): ?array
    {
        $query = [
            'filter' => [Filters::getFieldFilter('acceptance', $movement_id)]
        ];

        $this->response = ListMaker::getEntityList($this->reworker, $query, self::PATH."/item");
        return $this->getResponse($callback_class);
    }

    public function getMovementsByQuery(array $query, int $warehouse_id, ?string $callback_class = null): ?array
    {
        $query['warehouse'] = $warehouse_id;

        $this->response = ListMaker::getEntityList($this->reworker, $query, self::PATH);
        return $this->getResponse($callback_class);
    }
}