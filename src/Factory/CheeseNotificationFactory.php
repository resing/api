<?php

namespace App\Factory;

use App\Entity\CheeseNotification;
use App\Repository\CheeseNotificationRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static CheeseNotification|Proxy findOrCreate(array $attributes)
 * @method static CheeseNotification|Proxy random()
 * @method static CheeseNotification[]|Proxy[] randomSet(int $number)
 * @method static CheeseNotification[]|Proxy[] randomRange(int $min, int $max)
 * @method static CheeseNotificationRepository|RepositoryProxy repository()
 * @method CheeseNotification|Proxy create($attributes = [])
 * @method CheeseNotification[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class CheeseNotificationFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'cheeseListing' => CheeseListingFactory::new(),
            'notificationText' => self::faker()->realText(50),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->beforeInstantiate(function(CheeseNotification $cheeseNotification) {})
        ;
    }

    protected static function getClass(): string
    {
        return CheeseNotification::class;
    }
}
