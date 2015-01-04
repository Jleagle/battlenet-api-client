<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Exceptions\BattleNetException;
use Jleagle\BattleNet\Responses\AchievementResponse;
use Jleagle\BattleNet\Responses\AuctionResponse;
use Jleagle\BattleNet\Responses\BaseResponse;
use Jleagle\BattleNet\Responses\GuildResponse;
use Jleagle\BattleNet\Responses\RealmResponse;

class Warcraft extends BattleNet
{
  /**
   * @param int $achievementId
   *
   * @return AchievementResponse
   */
  public function getAchievement($achievementId)
  {
    $data = $this->_grab('achievement/' . $achievementId);
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
    $data = $this->_grab('auction/data/' . $realmSlug);

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
    $data = $this->_grab('data/battlegroups');
    return new BaseResponse($data);// todo, make response
  }

  public function getBattlePetAbility($abilityId)
  {
    $data = $this->_grab('battlePet/ability/' . $abilityId);
    return new BaseResponse($data);// todo, make response
  }

  public function getBattlePetSpecies($speciesId)
  {
    $data = $this->_grab('battlePet/species/' . $speciesId);
    return new BaseResponse($data);// todo, make response
  }

  public function getBattlePetStats(
    $speciesId, $level = 1, $breedId = 3, $qualityId = 1
  )
  {
    $data = $this->_grab(
      'battlePet/stats/' . $speciesId,
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
    $data = $this->_grab('challenge/' . $realmSlug);
    return new BaseResponse($data);// todo, make response
  }

  public function getChallengeRegionLeaderBoard()
  {
    $data = $this->_grab('challenge/region');
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
    $data   = $this->_grab(
      'guild/' . $realmSlug . '/' . $guildName,
      ['fields' => $fields]
    );
    return new GuildResponse($data);
  }

  public function getGuildAchievements()
  {
    $data = $this->_grab('data/guild/achievements');
    return new BaseResponse($data);// todo, make response
  }

  public function getGuildPerks()
  {
    $data = $this->_grab('data/guild/perks');
    return new BaseResponse($data);// todo, make response
  }

  public function getGuildRewards()
  {
    $data = $this->_grab('data/guild/rewards');
    return new BaseResponse($data);// todo, make response
  }

  public function getItem($itemId)
  {
    $data = $this->_grab('item/' . $itemId);
    return new BaseResponse($data);// todo, make response
  }

  public function getItemClasses()
  {
    $data = $this->_grab('data/item/classes');
    return new BaseResponse($data);// todo, make response
  }

  public function getItemSet($setId)
  {
    $data = $this->_grab('item/set/' . $setId);
    return new BaseResponse($data);// todo, make response
  }

  public function getPetTypes()
  {
    $data = $this->_grab('data/pet/types');
    return new BaseResponse($data);// todo, make response
  }

  public function getPlayer($realmSlug, $player, $fields = [])
  {
    $fields = implode(',', $fields);
    $data   = $this->_grab(
      'character/' . $realmSlug . '/' . $player,
      ['fields' => $fields]
    );
    return new GuildResponse($data);
  }

  public function getPlayerAchievements()
  {
    $data = $this->_grab('data/character/achievements');
    return new BaseResponse($data);// todo, make response
  }

  public function getPlayerClasses()
  {
    $data = $this->_grab('data/character/classes');
    return new BaseResponse($data);// todo, make response
  }

  public function getPvpLeaderBoard($bracket)
  {
    $data = $this->_grab('leaderboard/' . $bracket);
    return new BaseResponse($data);// todo, make response
  }

  public function getQuest($questId)
  {
    $data = $this->_grab('quest/' . $questId);
    return new BaseResponse($data);// todo, make response
  }

  public function getRaces()
  {
    $data = $this->_grab('data/character/races');
    return new BaseResponse($data);// todo, make response
  }

  /**
   * @return array
   */
  public function getRealms()
  {
    $data = $this->_grab('realm/status');

    $return = [];
    foreach($data['realms'] as $realm)
    {
      $return[] = new RealmResponse($realm);
    }
    return $return;
  }

  public function getRecipe($recipeId)
  {
    $data = $this->_grab('recipe/' . $recipeId);
    return new BaseResponse($data);// todo, make response
  }

  public function getSpell($spellId)
  {
    $data = $this->_grab('spell/' . $spellId);
    return new BaseResponse($data);// todo, make response
  }

  public function getTalents()
  {
    $data = $this->_grab('data/item/talents');
    return new BaseResponse($data);// todo, make response
  }
}
