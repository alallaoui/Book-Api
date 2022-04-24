<?php

namespace App\Tests\Functional;

class BookControllerTest extends ApiTestCase
{
    public function testGetBookListWillReturn401WhenNotLogged()
    {
        $client = static::createClient();
        $client->request('GET', '/api/book');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testGetBookListReturn200WhenLogged()
    {
        $client =  $this->createAuthenticatedClient('user0@books-library.com', 'pass_0');
        $client->request('GET', '/api/book');
        $this->assertResponseIsSuccessful();
    }
}
