<?php

namespace App\Service;

use App\Entity\DailyStats;
use App\Repository\CheeseListingRepository;

class StatsHelper
{
    private $cheeseListingRepository;

    public function __construct(CheeseListingRepository $cheeseListingRepository)
    {
        $this->cheeseListingRepository = $cheeseListingRepository;
    }

    /**
     * @param array An array of criteria to limit the results
     *              Supported keys are:
     *                  * from DateTimeInterface
     *                  * to   DateTimeInterface
     * @return array|DailyStats[]
     */
    public function fetchMany(int $limit = null, int $offset = null, array $criteria = [])
    {
        $fromDate = $criteria['from'] ?? null;
        $toDate = $criteria['to'] ?? null;

        $i = 0;
        $stats = [];
        foreach ($this->fetchStatsData() as $statData) {
            $i++;
            if ($offset >= $i) {

                continue;
            }

            $dateString = $statData['date'];
            $date = new \DateTimeImmutable($dateString);

            if ($fromDate && $date < $fromDate) {
                continue;
            }

            if ($toDate && $date > $toDate) {
                continue;
            }

            $stats[$dateString] = $this->createStatsObject($statData);

            if (null !== $limit && count($stats) >= $limit) {
                break;
            }
        }

        return $stats;
    }

    public function fetchOne(string $date): ?DailyStats
    {
        foreach ($this->fetchStatsData() as $statData) {
            if ($statData['date'] === $date) {
                return $this->createStatsObject($statData);
            }
        }

        return null;
    }

    public function count(): int
    {
        return count($this->fetchStatsData());
    }

    private function fetchStatsData(): array
    {
        $statsData = json_decode(file_get_contents(__DIR__.'/fake_stats.json'), true);

        return $statsData['stats'];
    }

    private function getRandomItems(array $items, int $max)
    {
        if ($max > count($items)) {
            shuffle($items);

            return $items;
        }

        $finalItems = [];
        while (count($finalItems) < $max) {
            $item = $items[array_rand($items)];
            if (!in_array($item, $finalItems)) {
                $finalItems[] = $item;
            }
        }

        return $finalItems;
    }

    private function createStatsObject(array $statData): DailyStats
    {
        $listings = $this->cheeseListingRepository
            ->findBy([], [], 10);

        return new DailyStats(
            new \DateTimeImmutable($statData['date']),
            $statData['visitors'],
            $this->getRandomItems($listings, 5)
        );
    }
}
