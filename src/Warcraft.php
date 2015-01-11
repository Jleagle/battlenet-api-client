<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Exceptions\BattleNetException;
use Jleagle\BattleNet\Responses\BaseResponse;
use Jleagle\BattleNet\Responses\Warcraft\AchievementResponse;
use Jleagle\BattleNet\Responses\Warcraft\AuctionResponse;
use Jleagle\BattleNet\Responses\Warcraft\GuildResponse;
use Jleagle\BattleNet\Responses\Warcraft\RealmResponse;

class Warcraft extends BattleNet
{
  private $_path = 'wow';

  /**
   * @param int $achievementId
   *
   * @return AchievementResponse
   */
  public function getAchievement($achievementId)
  {
    $data = $this->_grab($this->_path . '/achievement/' . $achievementId);
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
    $data = $this->_grab($this->_path . '/auction/data/' . $realmSlug);

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

  public function getBattleGroups()
  {
    $data = $this->_grab($this->_path . '/data/battlegroups');
    return new BaseResponse($data);// todo, make response
  }

  public function getBattlePetAbility($abilityId)
  {
    $data = $this->_grab($this->_path . '/battlePet/ability/' . $abilityId);
    return new BaseResponse($data);// todo, make response
  }

  public function getBattlePetSpecies($speciesId)
  {
    $data = $this->_grab($this->_path . '/battlePet/species/' . $speciesId);
    return new BaseResponse($data);// todo, make response
  }

  public function getBattlePetStats(
    $speciesId, $level = 1, $breedId = 3, $qualityId = 1
  )
  {
    $data = $this->_grab(
      $this->_path . '/battlePet/stats/' . $speciesId,
      [
        'level'     => $level,
        'breedId'   => $breedId,
        'qualityId' => $qualityId
      ]
    );
    return new BaseResponse($data);// todo, make response
  }

  public function getChallengeRealmLeaderBoard($realmSlug)
  {
    $data = $this->_grab($this->_path . '/challenge/' . $realmSlug);
    return new BaseResponse($data);// todo, make response
  }

  public function getChallengeRegionLeaderBoard()
  {
    $data = $this->_grab($this->_path . '/challenge/region');
    return new BaseResponse($data);// todo, make response
  }

  /**
   * @param string $realmSlug
   * @param string $guildName
   * @param array  $fields
   *
   * @return GuildResponse
   * @throws BattleNetException
   */
  public function getGuild($realmSlug, $guildName, $fields = [])
  {
    $fields = implode(',', $fields);
    $data = $this->_grab(
      $this->_path . '/guild/' . $realmSlug . '/' . $guildName,
      ['fields' => $fields]
    );
    return new GuildResponse($data);
  }

  public function getGuildAchievements()
  {
    $data = $this->_grab($this->_path . '/data/guild/achievements');
    return new BaseResponse($data);// todo, make response
  }

  public function getGuildPerks()
  {
    $data = $this->_grab($this->_path . '/data/guild/perks');
    return new BaseResponse($data);// todo, make response
  }

  public function getGuildRewards()
  {
    $data = $this->_grab($this->_path . '/data/guild/rewards');
    return new BaseResponse($data);// todo, make response
  }

  public function getItem($itemId)
  {
    $data = $this->_grab($this->_path . '/item/' . $itemId);
    return new BaseResponse($data);// todo, make response
  }

  public function getItemClasses()
  {
    $data = $this->_grab($this->_path . '/data/item/classes');
    return new BaseResponse($data);// todo, make response
  }

  public function getItemSet($setId)
  {
    $data = $this->_grab($this->_path . '/item/set/' . $setId);
    return new BaseResponse($data);// todo, make response
  }

  public function getPetTypes()
  {
    $data = $this->_grab($this->_path . '/data/pet/types');
    return new BaseResponse($data);// todo, make response
  }

  public function getPlayer($realmSlug, $player, $fields = [])
  {
    $fields = implode(',', $fields);
    $data = $this->_grab(
      $this->_path . '/character/' . $realmSlug . '/' . $player,
      ['fields' => $fields]
    );
    return new BaseResponse($data);// todo, make response
  }

  public function getPlayerAchievements()
  {
    $data = $this->_grab($this->_path . '/data/character/achievements');
    return new BaseResponse($data);// todo, make response
  }

  public function getPlayerClasses()
  {
    $data = $this->_grab($this->_path . '/data/character/classes');
    return new BaseResponse($data);// todo, make response
  }

  public function getPvpLeaderBoard($bracket)
  {
    $data = $this->_grab($this->_path . '/leaderboard/' . $bracket);
    return new BaseResponse($data);// todo, make response
  }

  public function getQuest($questId)
  {
    $data = $this->_grab($this->_path . '/quest/' . $questId);
    return new BaseResponse($data);// todo, make response
  }

  public function getRaces()
  {
    $data = $this->_grab($this->_path . '/data/character/races');
    return new BaseResponse($data);// todo, make response
  }

  /**
   * @return RealmResponse[]
   */
  public function getRealms()
  {
    $data = $this->_grab($this->_path . '/realm/status');

    $return = [];
    foreach($data['realms'] as $realm)
    {
      $return[] = new RealmResponse($realm);
    }
    return $return;
  }

  public function getRecipe($recipeId)
  {
    $data = $this->_grab($this->_path . '/recipe/' . $recipeId);
    return new BaseResponse($data);// todo, make response
  }

  public function getSpell($spellId)
  {
    $data = $this->_grab($this->_path . '/spell/' . $spellId);
    return new BaseResponse($data);// todo, make response
  }

  public function getTalents()
  {
    $data = $this->_grab($this->_path . '/data/item/talents');
    return new BaseResponse($data);// todo, make response
  }
}
