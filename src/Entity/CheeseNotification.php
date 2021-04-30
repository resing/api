<?php

namespace App\Entity;

use App\Repository\CheeseNotificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CheeseNotificationRepository::class)
 */
class CheeseNotification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CheeseListing::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $cheeseListing;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $notificationText;

    public function __construct(CheeseListing $cheeseListing, string $notificationText)
    {
        $this->cheeseListing = $cheeseListing;
        $this->notificationText = $notificationText;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheeseListing(): CheeseListing
    {
        return $this->cheeseListing;
    }

    public function getNotificationText(): string
    {
        return $this->notificationText;
    }
}
