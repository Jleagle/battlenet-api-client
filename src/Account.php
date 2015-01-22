<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Request\BattleNetAuth;
use Jleagle\BattleNet\Responses\BaseResponse;

class Account extends BattleNetAuth
{
  private $_path = 'account';

  public function getAccountId($accessToken)
  {
    $data = $this->_grab($this->_path . '/user/id', $accessToken);
    return new BaseResponse($data);// todo, make response
  }

  public function getBattleTag($accessToken)
  {
    $data = $this->_grab($this->_path . '/user/battletag', $accessToken);
    return new BaseResponse($data);// todo, make response
  }
}
