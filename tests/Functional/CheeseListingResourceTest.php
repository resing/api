<?php


namespace App\Tests\Functional;

use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class CheeseListingResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;
    public function testCreateCheeseListing()
    {
        $client = self::createClient();
        $client->request('POST', '/api/cheeses', [
            'json' => [],
        ]);

        $this->createUserAndLogIn($client, 'cheeseplease@example.com', 'foo');
    }
}
