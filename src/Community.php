<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Request\BattleNetAuth;
use Jleagle\BattleNet\Responses\Community\StarCraftCharacterResponse;
use Jleagle\BattleNet\Responses\Community\WarcraftCharacterResponse;

class Community extends BattleNetAuth
{
  /**
   * @param string $accessToken
   *
   * @return StarCraftCharacterResponse[]
   */
  public function getStarCraftUser($accessToken)
  {
    $data = $this->_grab('sc2/profile/user', $accessToken);

    $return = [];
    foreach($data['characters'] as $character)
    {
      $return[] = new StarCraftCharacterResponse($character);
    }
    return $return;
  }

  /**
   * @param string $accessToken
   *
   * @return WarcraftCharacterResponse[]
   */
  public function getWarcraftCharacters($accessToken)
  {
    $data = $this->_grab('wow/user/characters', $accessToken);

    $return = [];
    foreach($data['characters'] as $character)
    {
      $return[] = new WarcraftCharacterResponse($character);
    }
    return $return;
  }
}
