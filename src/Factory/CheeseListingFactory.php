<?php

namespace App\Factory;

use App\Entity\CheeseListing;
use App\Repository\CheeseListingRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static CheeseListing|Proxy createOne(array $attributes = [])
 * @method static CheeseListing[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static CheeseListing|Proxy find($criteria)
 * @method static CheeseListing|Proxy findOrCreate(array $attributes)
 * @method static CheeseListing|Proxy first(string $sortedField = 'id')
 * @method static CheeseListing|Proxy last(string $sortedField = 'id')
 * @method static CheeseListing|Proxy random(array $attributes = [])
 * @method static CheeseListing|Proxy randomOrCreate(array $attributes = [])
 * @method static CheeseListing[]|Proxy[] all()
 * @method static CheeseListing[]|Proxy[] findBy(array $attributes)
 * @method static CheeseListing[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CheeseListing[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CheeseListingRepository|RepositoryProxy repository()
 * @method CheeseListing|Proxy create($attributes = [])
 */
final class CheeseListingFactory extends ModelFactory
{
    public function published(): self
    {
        return $this->addState(['isPublished' => true]);
    }

    public function withLongDescription(): self
    {
        return $this->addState([
            'description' => self::faker()->paragraphs(3, true)
        ]);
    }

    public function withTitle(): self
    {
        return $this->addState([
            'title' => self::faker()->text(200)
        ]);
    }

    protected function getDefaults(): array
    {
        return [
            'title' => 'Block of cheddar',
            'description' => 'What can I say? A raw cube of cheese power',
            'price' => 1500,
            'owner' => UserFactory::new(),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->beforeInstantiate(function(CheeseListing $cheeseListing) {})
            ;
    }

    protected static function getClass(): string
    {
        return CheeseListing::class;
    }
}
