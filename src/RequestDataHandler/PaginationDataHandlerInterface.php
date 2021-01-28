<?php

declare(strict_types=1);

namespace Tavy315\SyliusRecommendationsPlugin\RequestDataHandler;

interface PaginationDataHandlerInterface
{
    public const PAGE_INDEX = 'page';

    public const LIMIT_INDEX = 'limit';

    public const DEFAULT_LIMIT = 48;

    public const AVAILABLE_LIMITS = [ 48 ];

    public function retrieveData(array $requestData): array;
}
