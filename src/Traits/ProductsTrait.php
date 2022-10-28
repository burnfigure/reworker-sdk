<?php

namespace Reworker\Traits;

use Reworker\Handlers\Filters;
use Reworker\Handlers\ListMaker;

trait ProductsTrait
{

    public function addProduct(array $data, int $shop_id, ?string $callback_class = null): ?array
    {
        $this->response = $this->reworker->post(self::PATH."/{$shop_id}", $data);
        return $this->getResponse($callback_class);
    }

    public function updateProduct(array $data, int $product_id, int $shop_id, ?string $callback_class = null): ?array
    {
        $this->response = $this->reworker->post(self::PATH."/{$shop_id}/{$product_id}", $data, true);
        return $this->getResponse($callback_class);
    }

    public function getProductsByArticles(array $articles, ?string $callback_class = null): ?array
    {
        $query = [
            'order-by' => [Filters::getDefaultOrderFilter()],
            'filter' => [Filters::getFieldFilter('article', $articles, 'in')]
        ];

        return $this->getProductsByQuery($query, $callback_class);
    }

    public function getProductsByArticle(string $article, ?string $callback_class = null): ?array
    {
        $query = [
            'filter' => [Filters::getFieldFilter('article', $article)]
        ];

        return $this->getProductsByQuery($query, $callback_class);
    }

    public function getProductsByQuery(array $query, ?string $callback_class = null): ?array
    {
        $this->response = ListMaker::getEntityList($this->reworker, $query, self::PATH);
        return $this->getResponse($callback_class);
    }
}