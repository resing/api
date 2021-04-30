<?php

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static User|Proxy createOne(array $attributes = [])
 * @method static User[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static User|Proxy find($criteria)
 * @method static User|Proxy findOrCreate(array $attributes)
 * @method static User|Proxy first(string $sortedField = 'id')
 * @method static User|Proxy last(string $sortedField = 'id')
 * @method static User|Proxy random(array $attributes = [])
 * @method static User|Proxy randomOrCreate(array $attributes = [])
 * @method static User[]|Proxy[] all()
 * @method static User[]|Proxy[] findBy(array $attributes)
 * @method static User[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static User[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static UserRepository|RepositoryProxy repository()
 * @method User|Proxy create($attributes = [])
 */
final class UserFactory extends ModelFactory
{
    const DEFAULT_PASSWORD = 'test';

    protected function getDefaults(): array
    {

        return [
            'email' => self::faker()->email(),
            'username' => self::faker()->userName(),
            // hashed version of "test"
            // php bin/console security:encode-password --env=test
            'password' => '$argon2id$v=19$m=65536,t=4,p=1$bzAatP5xGsuwplQiMEGp+g$3j4xgYNPPPXQreXXYhE50QvEConl4LOUbGHAAepoYKA',
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->beforeInstantiate(function(User $user) {})
            ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
