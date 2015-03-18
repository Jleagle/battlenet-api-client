<?php
namespace Jleagle\BattleNet\Responses\Warcraft;

use Jleagle\BattleNet\Responses\BaseResponse;

class PvpLeaderboardResponse extends BaseResponse
{
  public $ranking;
  public $rating;
  public $name;
  public $realmId;
  public $realmName;
  public $realmSlug;
  public $raceId;
  public $classId;
  public $specId;
  public $factionId;
  public $genderId;
  public $seasonWins;
  public $seasonLosses;
  public $weeklyWins;
  public $weeklyLosses;
}
