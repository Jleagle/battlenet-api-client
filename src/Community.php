<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Request\BattleNetAuth;
use Jleagle\BattleNet\Responses\BaseResponse;

class Community extends BattleNetAuth
{
  public function getStarCraftUser($accessToken)
  {
    $data = $this->_grab('sc2/profile/user', $accessToken);
    return new BaseResponse($data);// todo, make response
  }

  public function getWarcraftCharacters($accessToken)
  {
    $data = $this->_grab('wow/user/characters', $accessToken);
    return new BaseResponse($data);// todo, make response
  }
}
