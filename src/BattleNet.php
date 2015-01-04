<?php
namespace Jleagle\BattleNet;

use GuzzleHttp\Client;
use Jleagle\BattleNet\Enums\ServerLocations;
use Jleagle\BattleNet\Exceptions\BattleNetException;
use Jleagle\BattleNet\Responses\AchievementResponse;
use Jleagle\BattleNet\Responses\AuctionResponse;
use Jleagle\BattleNet\Responses\BaseResponse;
use Jleagle\BattleNet\Responses\GuildResponse;
use Jleagle\BattleNet\Responses\RealmResponse;

class BattleNet
{
  private $_apiKey;
  private $_serverLocation;
  private $_responseLocale;
  private $_jsonP;

  /**
   * @param string $apiKey
   * @param string $serverLocation
   * @param string $responseLocale
   */
  public function __construct(
    $apiKey, $serverLocation = ServerLocations::US, $responseLocale = null
  )
  {
    $this->_apiKey         = $apiKey;
    $this->_serverLocation = $serverLocation;
    $this->_responseLocale = $responseLocale;
  }

  public function setJsonp($callback)
  {
    $this->_jsonP = $callback;
  }

  /**
   * @param string $path
   * @param array  $options
   * @param array  $query
   *
   * @return array
   * @throws BattleNetException
   */
  protected function _grab($path, $query = [], $options = [])
  {
    $client = new Client();

    if($this->_responseLocale)
    {
      $query = array_merge_recursive(
        $query,
        ['locale' => $this->_responseLocale]
      );
    }
    if($this->_jsonP)
    {
      $query = array_merge_recursive(
        $query,
        ['jsonp' => $this->_jsonP]
      );
    }
    $query   = array_merge_recursive($query, ['apikey' => $this->_apiKey]);
    $options = array_merge_recursive($options, ['query' => $query]);

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

  /**
   * @param string $path
   *
   * @return string
   */
  private function _makeApiUrl($path)
  {
    return 'https://' . $this->_serverLocation . '.api.battle.net/wow/' . $path;
  }
}
