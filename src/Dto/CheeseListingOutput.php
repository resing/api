<?php

namespace App\Dto;

use App\Entity\CheeseListing;
use App\Entity\User;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class CheeseListingOutput
{
    /**
     * the title of cheese
     * @var string
     * @Groups({"cheese:read", "user:read"})
     */
    public $title;

    /**
     * @var string
     * @Groups({"cheese:read"})
     */
    public $description;

    /**
     * The price of this delicious cheese, in cents
     *
     * @Groups({"cheese:read", "user:read"})
     */
    public $price;

    /**
     * @var User
     * @Groups({"cheese:read"})
     */
    public $owner;

    /**
     * @Groups("cheese:read")
     */
    public function getShortDescription(): ?string
    {
        if (strlen($this->description) < 40) {
            return $this->description;
        }

        return substr($this->description, 0, 40).'...';
    }

    public $createdAt;
    /**
     * How long ago in text that this cheese listing was added.
     *
     * @Groups("cheese:read")
     */
    public function getCreatedAtAgo(): string
    {
        return Carbon::instance($this->createdAt)->diffForHumans();
    }

    public static function createFromEntity(CheeseListing $cheeseListing): self
    {
        $output = new CheeseListingOutput();
        $output->title = $cheeseListing->getTitle();
        $output->description = $cheeseListing->getDescription();
        $output->price = $cheeseListing->getPrice();
        $output->createdAt = $cheeseListing->getCreatedAt();
        $output->owner = $cheeseListing->getOwner();

        return $output;
    }
}
