<?php
namespace Jleagle\BattleNet\Responses\Warcraft;

use Jleagle\BattleNet\Responses\BaseResponse;

class BattlePetStatsResponse extends BaseResponse
{
  public $speciesId;
  public $breedId;
  public $petQualityId;
  public $level;
  public $health;
  public $power;
  public $speed;
}
