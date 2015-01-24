<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Request\BattleNetAuth;
use Jleagle\BattleNet\Responses\Account\BattleTagResponse;
use Jleagle\BattleNet\Responses\Account\UserResponse;

class Account extends BattleNetAuth
{
  private $_path = 'account';

  /**
   * @param string $accessToken
   *
   * @return UserResponse
   * @throws Exceptions\BattleNetException
   */
  public function getAccountId($accessToken)
  {
    $data = $this->_grab($this->_path . '/user/id', $accessToken);
    return new UserResponse($data);
  }

  /**
   * @param string $accessToken
   *
   * @return BattleTagResponse
   * @throws Exceptions\BattleNetException
   */
  public function getBattleTag($accessToken)
  {
    $data = $this->_grab($this->_path . '/user/battletag', $accessToken);
    return new BattleTagResponse($data);
  }
}
