<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Request\BattleNet;
use Jleagle\BattleNet\Responses\BaseResponse;
use Jleagle\BattleNet\Responses\StarCraft\AchievementResponse;
use Jleagle\BattleNet\Responses\StarCraft\RewardResponse;

class StarCraft extends BattleNet
{
  private $_path = 'sc2';

  public function getProfile($id, $region, $name)
  {
    $data = $this->_grab(
      $this->_path . '/profile/' . $id . '/' . $region . '/' . $name
    );
    return new BaseResponse($data);// todo, make response
  }

  public function getProfileLadders($id, $region, $name)
  {
    $data = $this->_grab(
      $this->_path . '/profile/' . $id . '/' . $region . '/' . $name . '/ladders'
    );
    return new BaseResponse($data);// todo, make response
  }

  public function getProfileMatches($id, $region, $name)
  {
    $data = $this->_grab(
      $this->_path . '/profile/' . $id . '/' . $region . '/' . $name . '/matches'
    );
    return new BaseResponse($data);// todo, make response
  }

  public function getLadder($ladderId)
  {
    $data = $this->_grab($this->_path . '/ladder/' . $ladderId);
    return new BaseResponse($data);// todo, make response
  }

  /**
   * @return AchievementResponse[]
   * @throws Exceptions\BattleNetException
   */
  public function getAchievements()
  {
    $data = $this->_grab($this->_path . '/data/achievements');
    $categories = $this->_restructureCategories($data['categories']);

    $achievements = [];
    foreach($data['achievements'] as $key => $achievement)
    {
      $categoryId = $achievement['categoryId'];
      $achievement['category'] = $categories[$categoryId];
      unset($achievement['categoryId']);
      $achievements[] = new AchievementResponse($achievement);
    }
    return $achievements;
  }

  /**
   * @param array $categories
   *
   * @return array
   */
  private function _restructureCategories(array $categories)
  {
    $return = [];
    foreach($categories as $catKey => $cat)
    {
      $catId = $cat['categoryId'];
      $return[$catId] = [
        'title'                 => $cat['title'],
        'categoryId'            => $cat['categoryId'],
        'featuredAchievementId' => $cat['featuredAchievementId']
      ];

      if(isset($cat['children']) && is_array($cat['children']))
      {
        foreach($cat['children'] as $subCatKey => $subCat)
        {
          $subCatId = $subCat['categoryId'];
          $return[$subCatId] = [
            'title'                       => $subCat['title'],
            'categoryId'                  => $subCat['categoryId'],
            'featuredAchievementId'       => $subCat['featuredAchievementId'],
            'parentTitle'                 => $cat['title'],
            'parentCategoryId'            => $cat['categoryId'],
            'parentFeaturedAchievementId' => $cat['featuredAchievementId']
          ];
        }
      }
    }
    return $return;
  }

  /**
   * @return RewardResponse[]
   * @throws Exceptions\BattleNetException
   */
  public function getRewards()
  {
    $data = $this->_grab($this->_path . '/data/rewards');

    $return = [];
    foreach($data as $type => $rewards)
    {
      foreach($rewards as $reward)
      {
        $reward['type'] = $type;
        $return[] = new RewardResponse($reward);
      }
    }

    return $return;
  }
}
