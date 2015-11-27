<?php
namespace Jleagle\BattleNet\Request;

use Jleagle\BattleNet\Enums\AuthScopes;
use Jleagle\BattleNet\Enums\ServerLocations;
use Jleagle\BattleNet\Exceptions\BattleNetException;
use Jleagle\CurlWrapper\Curl;
use Jleagle\CurlWrapper\Exceptions\CurlException;
use Jleagle\CurlWrapper\Exceptions\CurlInvalidJsonException;

abstract class AbstractBattleNetAuth
{
  use BattleNetTrait;

  protected $_apiSecret;
  protected $_redirectUrl;
  protected $_scopes;

  /**
   * @param string   $apiKey
   * @param string   $apiSecret
   * @param string   $redirectUrl
   * @param string[] $scopes
   * @param string   $serverLocation
   * @param string   $responseLocale
   */
  public function __construct(
    $apiKey, $apiSecret, $redirectUrl, $scopes = [],
    $serverLocation = ServerLocations::US, $responseLocale = null
  )
  {
    $this->_apiKey = $apiKey;
    $this->_apiSecret = $apiSecret;
    $this->_redirectUrl = $redirectUrl;
    $this->_scopes = $scopes;
    $this->_serverLocation = $serverLocation;
    $this->_responseLocale = $responseLocale;
  }

  /**
   * @return string
   */
  private function _getScopes()
  {
    $scopes = $this->_scopes;
    if(!$scopes)
    {
      $scopes = [AuthScopes::WOW, AuthScopes::SC2];
    }
    return implode(' ', $scopes);
  }

  /**
   * @param string|null $state
   * @param bool        $redirect
   *
   * @return string[]
   */
  public function getCode($state = null, $redirect = false)
  {
    if(!$state)
    {
      $state = rand(11111, 99999);
    }

    $params = http_build_query(
      [
        'client_id'     => $this->_apiKey,
        'scope'         => $this->_getScopes(),
        'state'         => $state,
        'redirect_uri'  => $this->_redirectUrl,
        'response_type' => 'code',
      ]
    );
    $url = 'https://' . $this->_serverLocation . '.battle.net/oauth/authorize?' . $params;

    if($redirect)
    {
      header('Location: ' . $url);
      exit;
    }

    return ['redirectUrl' => $url, 'state' => $state];
  }

  /**
   * Each code can only be used once
   *
   * @param string $code
   *
   * @return array
   *
   * @throws CurlException
   * @throws CurlInvalidJsonException
   */
  public function getAccessToken($code)
  {
    $url = 'https://' . $this->_serverLocation . '.battle.net/oauth/token';

    $data = [
      'redirect_uri' => $this->_redirectUrl,
      'scope'        => $this->_getScopes(),
      'grant_type'   => 'authorization_code',
      'code'         => $code,
    ];

    return Curl::post($url, $data)
      ->setBasicAuth($this->_apiKey, $this->_apiSecret)
      ->run()
      ->getJson();
  }

  /**
   * @param string $path
   * @param string $accessToken
   *
   * @return array
   * @throws BattleNetException
   */
  protected function _get($path, $accessToken)
  {
    $data = ['access_token' => $accessToken];

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
