<?php
// ...
use Symfony\Component\HTTPFoundation\Response;
class DiaryControllerTest extends WebTestCase
{
  private $client = null;
  
  public function setUp()
  {
    $this->client = static::createClient();
  }
  
  public function testHomepageIsUp()
  {
    $this->client->request('GET', '/');
    
    static::assertEquals(
      Response::HTTP_OK,
      $this->client->getResponse()->getStatusCode()
    );
  }

  <?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DiaryControllerTest extends WebTestCase
{
    // …

    public function testAddRecord()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/diary/add-new-record');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['food[username]'] = 'John Doe';
        $form['food[entitled]'] = 'Plat de pâtes';
        $form['food[calories]'] = 600;
        $client->submit($form);

        $crawler = $client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

      public function testList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler->selectLink('Voir tous les rapports')->link();
        $crawler = $client->click($link);

        $info = $crawler->filter('h1')->text();
        $info = $string = trim(preg_replace('/\s\s+/', ' ', $info)); // On retire les retours à la ligne pour faciliter la vérification

        $this->assertSame("Tous les rapports Tout ce qui a été mangé !", $info);
    }
    
}

}