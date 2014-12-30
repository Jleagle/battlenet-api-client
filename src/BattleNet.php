<?php
namespace Jleagle\BattleNet;

use GuzzleHttp\Client;
use Jleagle\BattleNet\Enums\ServerLocale;
use Jleagle\BattleNet\Exceptions\BattleNetException;
use Jleagle\BattleNet\Responses\AchievementResponse;
use Jleagle\BattleNet\Responses\AuctionResponse;
use Jleagle\BattleNet\Responses\GuildResponse;
use Jleagle\BattleNet\Responses\RealmResponse;

class BattleNet
{
  private $_apiKey;
  private $_serverLocale;
  private $_responseLocale;

  /**
   * @param string $apiKey
   * @param string $serverLocale
   * @param string $responseLocale
   */
  public function __construct(
    $apiKey, $serverLocale = ServerLocale::US, $responseLocale = null
  )
  {
    $this->_apiKey         = $apiKey;
    $this->_serverLocale   = $serverLocale;
    $this->_responseLocale = $responseLocale;
  }

  /**
   * @param int $achievementId
   *
   * @return AchievementResponse
   */
  public function getAchievement($achievementId)
  {
    $data = $this->_grab('achievement/' . $achievementId);
    return new AchievementResponse($data);
  }

  /**
   * @param string $realmSlug
   *
   * @return AuctionResponse
   * @throws BattleNetException
   */
  public function getAuctions($realmSlug)
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

  /**
   * @param string $guildName
   * @param array  $fields
   *
   * @return GuildResponse

   */
  public function getGuild(
    $guildName, $fields = ['members', 'achievements', 'news', 'challenge']
  )
  {
    $fields = implode(',', $fields);
    $data   = $this->_grab(
      'guild/outland/' . $guildName,
      ['fields' => $fields]
    );
    return new GuildResponse($data);
  }

  /**
   * @return array
   */
  public function getRealms()
  {
    $data = $this->_grab('realm/status');

    $return = [];
    foreach($data['realms'] as $realm)
    {
      $return[] = new RealmResponse($realm);
    }
    return $return;
  }

  /**
   * @param string $path
   *
   * @return string
   */
  private function _makeApiUrl($path)
  {
    return 'https://' . $this->_serverLocale . '.api.battle.net/wow/' . $path;
  }

  /**
   * @param string $path
   * @param array  $options
   * @param array  $query
   *
   * @return array
   * @throws BattleNetException
   */
  private function _grab($path, $query = [], $options = [])
  {
    $client = new Client();

    if($this->_responseLocale)
    {
      $query = array_merge_recursive(
        $query,
        ['locale' => $this->_responseLocale]
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
}
