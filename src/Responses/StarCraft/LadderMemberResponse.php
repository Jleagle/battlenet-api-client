<?php
namespace Jleagle\BattleNet\Responses\StarCraft;

use Jleagle\BattleNet\Responses\BaseResponse;

class LadderMemberResponse extends BaseResponse
{
  public $character;
  public $joinTimestamp;
  public $points;
  public $wins;
  public $losses;
  public $highestRank;
  public $previousRank;
  public $favoriteRaceP1;
}
