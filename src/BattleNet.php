<?php
namespace Jleagle\BattleNet;

use GuzzleHttp\Client;
use Jleagle\BattleNet\Enums\ServerLocale;
use Jleagle\BattleNet\Exceptions\BattleNetException;
use Jleagle\BattleNet\Responses\AuctionResponse;

class BattleNet
{
  private $_apiKey;
  private $_serverLocale;
  private $_responseLocale;

  public function __construct(
    $apiKey, $serverLocale = ServerLocale::US, $responseLocale = null
  )
  {
    $this->_apiKey         = $apiKey;
    $this->_serverLocale   = $serverLocale;
    $this->_responseLocale = $responseLocale;
  }

  public function getAuction($realmSlug)
  {
    $data = $this->_grab('auction/data/' . $realmSlug);

    if(!isset($data['files'][0]['url']) || !isset($data['files'][0]['lastModified']))
    {
      throw new BattleNetException('Missing fields from API');
    }

    return new AuctionResponse(
      [
        'url'          => $data['files'][0]['url'],
        'lastModified' => $data['files'][0]['lastModified']
      ]
    );
  }

  private function _makeApiUrl($path)
  {
    return 'https://' . $this->_serverLocale . '.api.battle.net/wow/' . $path;
  }

  private function _grab($path, $options = [])
  {
    $client = new Client();

    if($this->_responseLocale)
    {
      $options['query']['locale'];
    }
    $options['query']['apikey'] = $this->_apiKey;

    $res = $client->get($this->_makeApiUrl($path), $options);

    if($res->getStatusCode() != 200)
    {
      throw new BattleNetException(
        'Invalid status code from API',
        $res->getStatusCode()
      );
    }

    return $res->json();
  }
}
