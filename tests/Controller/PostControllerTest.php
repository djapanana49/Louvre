<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostControllerTest
 *
 * @author djapa
 */
class PostControllerTest extends WebTestCase{
    
     public function testShowPost()
    {
        $client = static::createClient();
        $client->request('GET', '/recapitulatif');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
    
     public function testReservations()
    {
        $client = static::createClient();
        $client->request('GET', '/reservation');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    
    public function testIndex() {
        $client = static::createClient();
        $client->request('GET','/accueil');
        $this->assertSame(200,$client->getResponse()->getStatusCode());
    }
    
   
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        echo $url;
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/reservation'];
        yield ['/recapitulatif'];
        yield ['/succes'];
        yield ['/echec'];
        yield ['/payment'];
        // ...
    }
}
