<?php
namespace Jleagle\BattleNet\Request;

use GuzzleHttp\Client as Guzzle;
use Jleagle\BattleNet\Enums\ServerLocations;
use Jleagle\BattleNet\Exceptions\BattleNetException;

abstract class BattleNet
{
  use BattleNetTrait;

  protected $_apiKey;
  protected $_responseLocale;

  /**
   * @param string $apiKey
   * @param string $serverLocation
   * @param string $responseLocale
   */
  public function __construct(
    $apiKey, $serverLocation = ServerLocations::US, $responseLocale = null
  )
  {
    $this->_apiKey = $apiKey;
    $this->_serverLocation = $serverLocation;
    $this->_responseLocale = $responseLocale;
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
    $query = array_merge_recursive($query, ['apikey' => $this->_apiKey]);
    $options = array_merge_recursive($options, ['query' => $query]);

    $client = new Guzzle();
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
