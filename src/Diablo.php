<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Request\BattleNet;
use Jleagle\BattleNet\Responses\Diablo\ArtisanResponse;
use Jleagle\BattleNet\Responses\Diablo\CareerProfileResponse;
use Jleagle\BattleNet\Responses\Diablo\FollowerResponse;
use Jleagle\BattleNet\Responses\Diablo\HeroProfileResponse;
use Jleagle\BattleNet\Responses\Diablo\ItemResponse;

class Diablo extends BattleNet
{
  private $_path = 'd3';

  /**
   * @param string $battleTag
   *
   * @return CareerProfileResponse
   */
  public function getCareerProfile($battleTag)
  {
    $data = $this->_grab($this->_path . '/profile/' . urlencode($battleTag));
    return new CareerProfileResponse($data);
  }

  /**
   * @param string $battleTag
   * @param int    $id
   *
   * @return HeroProfileResponse
   */
  public function getHeroProfile($battleTag, $id)
  {
    $data = $this->_grab(
      $this->_path . '/profile/' . urlencode($battleTag) . '/hero/' . $id
    );
    return new HeroProfileResponse($data);
  }

  /**
   * @param string $itemDataString
   *
   * @return ItemResponse
   */
  public function getItem($itemDataString)
  {
    $data = $this->_grab($this->_path . '/data/item/' . $itemDataString);
    return new ItemResponse($data);
  }

  /**
   * @param string $follower
   *
   * @return FollowerResponse
   */
  public function getFollower($follower) // Todo, make enum
  {
    $data = $this->_grab($this->_path . '/data/follower/' . $follower);
    return new FollowerResponse($data);
  }

  /**
   * @param $artisan
   *
   * @return ArtisanResponse
   */
  public function getArtisan($artisan) // Todo, make enum
  {
    $data = $this->_grab($this->_path . '/data/artisan/' . $artisan);
    return new ArtisanResponse($data);
  }
}
