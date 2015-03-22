<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Request\BattleNet;
use Jleagle\BattleNet\Responses\StarCraft\AchievementResponse;
use Jleagle\BattleNet\Responses\StarCraft\LadderMemberResponse;
use Jleagle\BattleNet\Responses\StarCraft\LaddersResponse;
use Jleagle\BattleNet\Responses\StarCraft\MatchHistoryResponse;
use Jleagle\BattleNet\Responses\StarCraft\ProfileResponse;
use Jleagle\BattleNet\Responses\StarCraft\RewardResponse;

class StarCraft extends BattleNet
{
  private $_path = 'sc2';

  /**
   * @param int    $id
   * @param int    $region
   * @param string $name
   *
   * @return ProfileResponse
   */
  public function getProfile($id, $region, $name)
  {
    $data = $this->_grab(
      $this->_path . '/profile/' . $id . '/' . $region . '/' . $name . '/'
    );
    return new ProfileResponse($data);
  }

  /**
   * @param int    $id
   * @param int    $region
   * @param string $name
   *
   * @return LaddersResponse
   */
  public function getProfileLadders($id, $region, $name)
  {
    $data = $this->_grab(
      $this->_path . '/profile/' . $id . '/' . $region . '/' . $name . '/ladders'
    );
    return new LaddersResponse($data);
  }

  /**
   * @param int    $id
   * @param int    $region
   * @param string $name
   *
   * @return MatchHistoryResponse[]
   */
  public function getProfileMatches($id, $region, $name)
  {
    $data = $this->_grab(
      $this->_path . '/profile/' . $id . '/' . $region . '/' . $name . '/matches'
    );

    $return = [];
    foreach($data['matches'] as $match)
    {
      $return[] = new MatchHistoryResponse($match);
    }
    return $return;
  }

  /**
   * @param string $ladderId
   *
   * @return LadderMemberResponse[]
   */
  public function getLadder($ladderId) // todo, make enum
  {
    $data = $this->_grab($this->_path . '/ladder/' . $ladderId);

    $return = [];
    foreach($data['ladderMembers'] as $member)
    {
      $return[] = new LadderMemberResponse($member);
    }
    return $return;
  }

  /**
   * @return AchievementResponse[]
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
