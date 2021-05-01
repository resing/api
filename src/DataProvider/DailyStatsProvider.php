<?php


namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\Pagination;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\DailyStats;
use App\Filter\DailyStatsDateFilter;
use App\Repository\CheeseListingRepository;
use App\Service\StatsHelper;

class DailyStatsProvider implements ContextAwareCollectionDataProviderInterface,  ItemDataProviderInterface, RestrictedDataProviderInterface
{

    private $statsHelper;
    private $pagination;

    public function __construct(StatsHelper $statsHelper, Pagination $pagination)
    {
        $this->statsHelper = $statsHelper;
        $this->pagination = $pagination;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context= [])
    {

        list($page, $offset, $limit) = $this->pagination->getPagination($resourceClass, $operationName);

        $paginator =  new DailyStatsPaginator(
            $this->statsHelper,
            $page,
            $limit
        );

        $fromDate = $context[DailyStatsDateFilter::FROM_FILTER_CONTEXT] ?? null;

        if($fromDate) {
            $paginator->setFromDate($fromDate);
        }

        return $paginator;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        return $this->statsHelper->fetchOne($id);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === DailyStats::class;
    }
}
