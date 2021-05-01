<?php

namespace App\DataFixtures;

use App\Entity\CheeseListing;
use App\Entity\User;
use App\Factory\CheeseListingFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = UserFactory::new()->create([
            'email' => 'cheesefan@example.com',
            'username' => 'cheesefan',
            'roles' => ['ROLE_ADMIN'],
            'password' => $this->passwordEncoder->encodePassword(new User(), 'cheese'),
        ]);
        UserFactory::new()::createMany(50);

        $listingFactory = CheeseListingFactory::new([
            'owner' => $user,
        ])
            ->published();

        $listingFactory->create([
            'title' => 'Mysterious munster',
            'description' => 'Origin date: unknown. Actual origin... also unknown.',
            'price' => 1500,
        ]);

        $listingFactory->create([
            'title' => 'Block of cheddar the size of your face!',
            'description' => 'When I drive it to your house, it will sit in the passenger seat of my car.',
            'price' => 5000,
        ]);

        // then create 30 more
        $listingFactory::createMany(50);
    }
}