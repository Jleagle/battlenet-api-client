<?php
namespace Jleagle\BattleNet\Request;

use Jleagle\BattleNet\Enums\ServerLocations;
use Jleagle\BattleNet\Exceptions\BattleNetException;
use Jleagle\CurlWrapper\Curl;
use Jleagle\CurlWrapper\Exceptions\CurlException;

abstract class AbstractBattleNet
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
   * @param array  $data
   *
   * @return array
   * @throws BattleNetException
   */
  protected function _get($path, $data = [])
  {
    if($this->_responseLocale)
    {
      $data['locale'] = $this->_responseLocale;
    }

    if($this->_jsonP)
    {
      $data['jsonp'] = $this->_jsonP;
    }

    $data['apikey'] = $this->_apiKey;

    try
    {
      return Curl::get($this->_makeApiUrl($path), $data)->run()->getJson();
    }
    catch(CurlException $e)
    {
      $json = $e->getResponse()->getJson();
      $message = isset($json['reason']) ? $json['reason'] : $e->getMessage();
      throw new BattleNetException($message);
    }
  }
}
