<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\RequestDataHandler;

final class PaginationDataHandler implements PaginationDataHandlerInterface
{
    public function retrieveData(array $requestData): array
    {
        $data = [];

        $this->resolvePage($requestData, $data);
        $this->resolveLimit($requestData, $data);

        return $data;
    }

    private function resolvePage(array $requestData, array &$data): void
    {
        $page = 1;

        if (isset($requestData[self::PAGE_INDEX])) {
            $page = (int) $requestData[self::PAGE_INDEX];
        }

        $data[self::PAGE_INDEX] = $page;
    }

    private function resolveLimit(array $requestData, array &$data): void
    {
        $limit = self::DEFAULT_LIMIT;

        if (isset($requestData[self::LIMIT_INDEX])) {
            $limit = (int) $requestData[self::LIMIT_INDEX];
        }

        $data[self::LIMIT_INDEX] = $limit;
    }
}
