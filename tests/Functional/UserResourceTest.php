<?php


namespace App\Tests\Functional;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use App\Factory\UserFactory;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Ramsey\Uuid\Uuid;

class UserResourceTest extends CustomApiTestCase
{
    public function testCreateUser()
    {
        $client = self::createClient();

        $client->request('POST', '/api/users', [
            'json' => [
                'email' => 'cheeseplease@example.com',
                'username' => 'cheeseplease',
                'password' => 'brie'
            ]
        ]);
        $this->assertResponseStatusCodeSame(201);

        $user = UserFactory::repository()->findOneBy(['email' => 'cheeseplease@example.com']);
        $this->assertNotNull($user);
        $this->assertJsonContains([
            '@id' => '/api/users/'.$user->getUuid()->toString()
        ]);

        $this->logIn($client, 'cheeseplease@example.com', 'brie');
    }

    public function testUpdateUser()
    {
        $client = self::createClient();
        $user = UserFactory::new()->create();
        $this->logIn($client, $user);

        $client->request('PUT', '/api/users/'.$user->getUuid(), [
            'json' => [
                'username' => 'newusername',
                'roles' => ['ROLE_ADMIN'] // will be ignored
            ]
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'username' => 'newusername'
        ]);

        $user->refresh();
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testCreateUserWithUuid()
    {
        $client = self::createClient();
        $uuid = Uuid::uuid4();
        $client->request('POST', '/api/users', [
            'json' => [
                'id' => $uuid,
                'email' => 'cheeseplease@example.com',
                'username' => 'cheeseplease',
                'password' => 'brie'
            ],
            'headers' => ['Content-type' => 'application/ld+json']
        ]);
        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@id' => '/api/users/'.$uuid
        ]);
    }

    public function testGetUser()
    {
        $client = self::createClient();
        $user = UserFactory::new()->create([
            'phoneNumber' => '555.123.4567',
            'username' => 'cheesehead',
        ]);
        $authenticatedUser = UserFactory::new()->create();
        $this->logIn($client, $authenticatedUser);

        $data = $client
            ->request('GET', '/api/users/' . $user->getUuid())
            ->toArray();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'username' => $user->getUsername(),
            'isMvp' => true,
        ]);

        $this->assertArrayNotHasKey('phoneNumber', $data);
        $this->assertJsonContains([
            'isMe' => false,
        ]);

        // refresh the user & elevate
        $user->refresh();
        $user->setRoles(['ROLE_ADMIN']);
        $user->save();
        $this->logIn($client, $user);

        $client->request('GET', '/api/users/' . $user->getUuid());
        $this->assertJsonContains([
            'phoneNumber' => '555.123.4567',
            'isMe' => true,
        ]);
    }
}
