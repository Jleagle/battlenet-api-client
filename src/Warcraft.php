<?php
namespace Jleagle\BattleNet;

use Jleagle\BattleNet\Exceptions\BattleNetException;
use Jleagle\BattleNet\Request\BattleNet;
use Jleagle\BattleNet\Responses\Warcraft\AchievementResponse;
use Jleagle\BattleNet\Responses\Warcraft\AuctionResponse;
use Jleagle\BattleNet\Responses\Warcraft\BattleGroupResponse;
use Jleagle\BattleNet\Responses\Warcraft\BattlePetAbilityResponse;
use Jleagle\BattleNet\Responses\Warcraft\BattlePetSpeciesResponse;
use Jleagle\BattleNet\Responses\Warcraft\BattlePetStatsResponse;
use Jleagle\BattleNet\Responses\Warcraft\ChallengeRealmResponse;
use Jleagle\BattleNet\Responses\Warcraft\ChallengeRegionResponse;
use Jleagle\BattleNet\Responses\Warcraft\CharacterAchievementsResponse;
use Jleagle\BattleNet\Responses\Warcraft\CharacterClassResponse;
use Jleagle\BattleNet\Responses\Warcraft\CharacterResponse;
use Jleagle\BattleNet\Responses\Warcraft\GuildAchievementsResponse;
use Jleagle\BattleNet\Responses\Warcraft\GuildPerksResponse;
use Jleagle\BattleNet\Responses\Warcraft\GuildResponse;
use Jleagle\BattleNet\Responses\Warcraft\GuildRewardsResponse;
use Jleagle\BattleNet\Responses\Warcraft\ItemClassesResponse;
use Jleagle\BattleNet\Responses\Warcraft\ItemResponse;
use Jleagle\BattleNet\Responses\Warcraft\ItemSetResponse;
use Jleagle\BattleNet\Responses\Warcraft\PetTypeResponse;
use Jleagle\BattleNet\Responses\Warcraft\PvpLeaderboardResponse;
use Jleagle\BattleNet\Responses\Warcraft\QuestResponse;
use Jleagle\BattleNet\Responses\Warcraft\RaceResponse;
use Jleagle\BattleNet\Responses\Warcraft\RealmResponse;
use Jleagle\BattleNet\Responses\Warcraft\RecipeResponse;
use Jleagle\BattleNet\Responses\Warcraft\SpellResponse;
use Jleagle\BattleNet\Responses\Warcraft\TalentResponse;

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

  /**
   * @return BattleGroupResponse[]
   */
  public function getBattleGroups()
  {
    $data = $this->_grab($this->_path . '/data/battlegroups');

    $return = [];
    foreach($data['battlegroups'] as $battlegroup)
    {
      $return[] = new BattleGroupResponse($battlegroup);
    }
    return $return;
  }

  /**
   * @param int $abilityId
   *
   * @return BattlePetAbilityResponse
   */
  public function getBattlePetAbility($abilityId)
  {
    $data = $this->_grab($this->_path . '/battlePet/ability/' . $abilityId);
    return new BattlePetAbilityResponse($data);
  }

  /**
   * @param int $speciesId
   *
   * @return BattlePetSpeciesResponse
   */
  public function getBattlePetSpecies($speciesId)
  {
    $data = $this->_grab($this->_path . '/battlePet/species/' . $speciesId);
    return new BattlePetSpeciesResponse($data);
  }

  /**
   * @param int $speciesId
   * @param int $level
   * @param int $breedId
   * @param int $qualityId
   *
   * @return BattlePetStatsResponse
   */
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
    return new BattlePetStatsResponse($data);
  }

  /**
   * @param string $realmSlug
   *
   * @return ChallengeRealmResponse
   */
  public function getChallengeRealmLeaderboard($realmSlug)
  {
    $data = $this->_grab($this->_path . '/challenge/' . $realmSlug);
    return new ChallengeRealmResponse($data);
  }

  /**
   * @return ChallengeRegionResponse
   */
  public function getChallengeRegionLeaderboard()
  {
    $data = $this->_grab($this->_path . '/challenge/region');
    return new ChallengeRegionResponse($data);
  }

  /**
   * @param string $realmSlug
   * @param string $guildName
   * @param array  $fields
   *
   * @return GuildResponse
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

  /**
   * @return GuildAchievementsResponse
   */
  public function getGuildAchievements()
  {
    $data = $this->_grab($this->_path . '/data/guild/achievements');
    return new GuildAchievementsResponse($data);
  }

  /**
   * @return GuildPerksResponse
   */
  public function getGuildPerks()
  {
    $data = $this->_grab($this->_path . '/data/guild/perks');
    return new GuildPerksResponse($data);
  }

  /**
   * @return GuildRewardsResponse
   */
  public function getGuildRewards()
  {
    $data = $this->_grab($this->_path . '/data/guild/rewards');
    return new GuildRewardsResponse($data);
  }

  /**
   * @param int $itemId
   *
   * @return ItemResponse
   */
  public function getItem($itemId)
  {
    $data = $this->_grab($this->_path . '/item/' . $itemId);
    return new ItemResponse($data);
  }

  /**
   * @return ItemClassesResponse
   */
  public function getItemClasses()
  {
    $data = $this->_grab($this->_path . '/data/item/classes');
    return new ItemClassesResponse($data);
  }

  /**
   * @param int $setId
   *
   * @return ItemSetResponse
   */
  public function getItemSet($setId)
  {
    $data = $this->_grab($this->_path . '/item/set/' . $setId);
    return new ItemSetResponse($data);
  }

  /**
   * @return PetTypeResponse[]
   */
  public function getPetTypes()
  {
    $data = $this->_grab($this->_path . '/data/pet/types');

    $return = [];
    foreach($data['petTypes'] as $petType)
    {
      $return[] = new PetTypeResponse($petType);
    }
    return $return;
  }

  /**
   * @param string $realmSlug
   * @param string $character
   * @param array  $fields
   *
   * @return CharacterResponse
   */
  public function getCharacter($realmSlug, $character, $fields = [])
  {
    $fields = implode(',', $fields);
    $data = $this->_grab(
      $this->_path . '/character/' . $realmSlug . '/' . $character,
      ['fields' => $fields]
    );

    $data['thumbnail'] = 'http://' . $this->_serverLocation . '.battle.net/static-render/' . $this->_serverLocation . '/' . $data['thumbnail'];
    $data['characterClass'] = $data['class'];
    unset($data['class']);

    return new CharacterResponse($data);
  }

  /**
   * @return CharacterAchievementsResponse
   */
  public function getCharacterAchievements()
  {
    $data = $this->_grab($this->_path . '/data/character/achievements');
    return new CharacterAchievementsResponse($data);
  }

  /**
   * @return CharacterClassResponse[]
   */
  public function getCharacterClasses()
  {
    $data = $this->_grab($this->_path . '/data/character/classes');

    $return = [];
    foreach($data['classes'] as $class)
    {
      $return[] = new CharacterClassResponse($class);
    }
    return $return;
  }

  /**
   * @param string $bracket
   *
   * @return PvpLeaderboardResponse[]
   */
  public function getPvpLeaderboard($bracket)
  {
    $data = $this->_grab($this->_path . '/leaderboard/' . $bracket);

    $return = [];
    foreach($data['rows'] as $class)
    {
      $return[] = new PvpLeaderboardResponse($class);
    }
    return $return;
  }

  /**
   * @param int $questId
   *
   * @return QuestResponse
   */
  public function getQuest($questId)
  {
    $data = $this->_grab($this->_path . '/quest/' . $questId);
    return new QuestResponse($data);
  }

  /**
   * @return RaceResponse[]
   */
  public function getRaces()
  {
    $data = $this->_grab($this->_path . '/data/character/races');

    $return = [];
    foreach($data['races'] as $race)
    {
      $return[] = new RaceResponse($race);
    }
    return $return;
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

  /**
   * @param int $recipeId
   *
   * @return RecipeResponse
   */
  public function getRecipe($recipeId)
  {
    $data = $this->_grab($this->_path . '/recipe/' . $recipeId);
    return new RecipeResponse($data);
  }

  /**
   * @param int $spellId
   *
   * @return SpellResponse
   */
  public function getSpell($spellId)
  {
    $data = $this->_grab($this->_path . '/spell/' . $spellId);
    return new SpellResponse($data);
  }

  /**
   * @return TalentResponse[]
   */
  public function getTalents()
  {
    $data = $this->_grab($this->_path . '/data/talents');

    $return = [];
    foreach($data as $talent)
    {
      $return[] = new TalentResponse($talent);
    }
    return $return;
  }
}
