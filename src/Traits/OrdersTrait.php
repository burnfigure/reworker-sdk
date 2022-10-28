<?php

namespace Reworker\Traits;

use Reworker\Handlers\Filters;
use Reworker\Handlers\ListMaker;

trait OrdersTrait
{

    public function createOrder(array $data, ?string $callback_class = null): ?array
    {
        $this->response = $this->reworker->post(self::PATH, $data);
        return $this->getResponse($callback_class);
    }

    public function updateOrder(array $data, ?string $callback_class = null): ?array
    {
        $this->response = $this->reworker->post(self::PATH, $data, true);
        return $this->getResponse($callback_class);
    }

    public function getOrderByID(int $order_id, ?string $callback_class = null): ?array
    {
        $this->response = $this->reworker->get(self::PATH."/{$order_id}");
        return $this->getResponse($callback_class);
    }

    public function getOrderProducts(int $order_id, ?string $callback_class = null): ?array
    {
        $filter = Filters::getFieldFilter('order', $order_id);
        $filter['alias'] = 'op';

        $query = [
            'filter' => [$filter]
        ];

        $this->response = ListMaker::getEntityList($this->reworker, $query, self::PATH."/product");
        return $this->getResponse($callback_class);
    }

    public function getOrdersByExtID($ext_id, ?string $callback_class = null): ?array
    {
        $query = [
            "filter" => [Filters::getFieldFilter('extId', $ext_id)]
        ];

        return $this->getOrdersByQuery($query, $callback_class);
    }

    public function getOrdersByExtIDs(array $ext_ids, ?string $callback_class = null): ?array
    {
        $query = [
            'order-by' => [Filters::getDefaultOrderFilter()],
            'filter' => [Filters::getFieldFilter('extId', $ext_ids, 'in')]
        ];

        return $this->getOrdersByQuery($query, $callback_class);
    }

    public function getOrdersBySource(int $source_id, ?string $callback_class = null): ?array
    {
        $query = [
            "order-by" => [Filters::getDefaultOrderFilter()],
            'filter' => [Filters::getFieldFilter('source', $source_id)],
        ];

        return $this->getOrdersByQuery($query, $callback_class);
    }

    public function getOrdersByStatus(string $status, ?string $callback_class = null): ?array
    {
        $query = [
            'filter' => [Filters::getFieldFilter('state', $status)],
        ];

        return $this->getOrdersByQuery($query, $callback_class);
    }


    public function getOrdersByQuery(array $query, ?string $callback_class = null): ?array
    {
        $this->response = ListMaker::getEntityList($this->reworker, $query, self::PATH);
        return $this->getResponse($callback_class);
    }

}