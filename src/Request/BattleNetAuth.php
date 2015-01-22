<?php
namespace Jleagle\BattleNet\Request;

use GuzzleHttp\Client as Guzzle;
use Jleagle\BattleNet\Enums\AuthScopes;
use Jleagle\BattleNet\Enums\ServerLocations;
use Jleagle\BattleNet\Exceptions\BattleNetException;

abstract class BattleNetAuth
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

  private function _getScopes()
  {
    $scopes = $this->_scopes;
    if(!$scopes)
    {
      $scopes = [AuthScopes::WOW, AuthScopes::SC2];
    }
    return implode(' ', $scopes);
  }

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

  public function getAccessToken($code)
  {
    $url = 'https://' . $this->_serverLocation . '.battle.net/oauth/token';
    $client = new Guzzle();
    $response = $client->post(
      $url,
      [
        'body' => [
          'redirect_uri' => $this->_redirectUrl,
          'scope'        => $this->_getScopes(),
          'grant_type'   => 'authorization_code',
          'code'         => $code,
        ],
        'auth' => [$this->_apiKey, $this->_apiSecret]
      ]
    );

    return $response->json();
  }

  /**
   * @param string $path
   * @param string $accessToken
   *
   * @return array
   * @throws BattleNetException
   */
  protected function _grab($path, $accessToken)
  {
    $client = new Guzzle();
    $res = $client->get(
      $this->_makeApiUrl($path),
      [
        'query' => ['access_token' => $accessToken]
      ]
    );

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
