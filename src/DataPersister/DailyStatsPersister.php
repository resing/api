<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\DailyStats;
use Psr\Log\LoggerInterface;

class DailyStatsPersister implements DataPersisterInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function supports($data): bool
    {
        return $data instanceof DailyStats;
    }

    /**
     * @param DailyStats $data
     */
    public function persist($data)
    {
        $this->logger->info(sprintf('Update the visitors to "%d"', $data->totalVisitors));
    }

    public function remove($data)
    {
        // TODO: Implement remove() method.
    }
}
