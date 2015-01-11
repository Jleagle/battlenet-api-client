<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Responses\BaseResponse;

class Diablo extends BattleNet
{
  private $_path = 'd3';

  public function getCareerProfile($battleTag)
  {
    $data = $this->_grab($this->_path . '/profile/' . $battleTag);
    return new BaseResponse($data);// todo, make response
  }

  public function getHeroProfile($battleTag, $id)
  {
    $data = $this->_grab(
      $this->_path . '/profile/' . $battleTag . '/hero/' . $id
    );
    return new BaseResponse($data);// todo, make response
  }

  public function getItem($itemDataString)
  {
    $data = $this->_grab($this->_path . '/data/item/' . $itemDataString);
    return new BaseResponse($data);// todo, make response
  }

  public function getFollower($follower)
  {
    $data = $this->_grab($this->_path . '/data/follower/' . $follower);
    return new BaseResponse($data);// todo, make response
  }

  public function getArtisan($artisan)
  {
    $data = $this->_grab($this->_path . '/data/artisan/' . $artisan);
    return new BaseResponse($data);// todo, make response
  }
}
