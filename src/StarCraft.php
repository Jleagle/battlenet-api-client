<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Responses\BaseResponse;

class StarCraft extends BattleNet
{
  private $_path = 'sc2';

  public function getProfile($id, $region, $name)
  {
    $data = $this->_grab($this->_path . '/profile/' . $id.'/'.$region.'/'.$name);
    return new BaseResponse($data);// todo, make response
  }

  public function getProfileLadders($id, $region, $name)
  {
    $data = $this->_grab($this->_path . '/profile/' . $id.'/'.$region.'/'.$name.'/ladders');
    return new BaseResponse($data);// todo, make response
  }

  public function getProfileMatches($id, $region, $name)
  {
    $data = $this->_grab($this->_path . '/profile/' . $id.'/'.$region.'/'.$name.'/matches');
    return new BaseResponse($data);// todo, make response
  }

  public function getLadder($ladderId)
  {
    $data = $this->_grab($this->_path . '/ladder/' . $ladderId);
    return new BaseResponse($data);// todo, make response
  }

  public function getAchievements()
  {
    $data = $this->_grab($this->_path . '/data/achievements');
    return new BaseResponse($data);// todo, make response
  }

  public function getRewards()
  {
    $data = $this->_grab($this->_path . '/data/rewards');
    return new BaseResponse($data);// todo, make response
  }
}
