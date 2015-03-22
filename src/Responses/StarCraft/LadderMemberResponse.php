<?php
namespace Jleagle\BattleNet\Responses\StarCraft;

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
