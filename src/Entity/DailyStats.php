<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Action\NotFoundAction;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"dailystats:read"}},
 *     itemOperations={
 *         "get"
 *     },
 *     collectionOperations={"get"}
 * )
 */
class DailyStats
{

    /**
     * @Groups({"dailystats:read"})
     */
    public $date;

    /**
     * @Groups({"dailystats:read"})
     */
    public $totalVisitors;

    /**
     * @var array<CheeseListing>|CheeseListing[]
     * @Groups({"dailystats:read"})
     */
    public $motPopularListings;


    public function __construct(\DateTimeInterface $date, int $totalVisitors, array $motPopularListings)
    {
        $this->date = $date;
        $this->totalVisitors = $totalVisitors;
        $this->motPopularListings = $motPopularListings;
    }

    /**
     * @ApiProperty(identifier=true)
     */
    public function getDateString(): string
    {
        return $this->date->format('Y-m-d');
    }
}
