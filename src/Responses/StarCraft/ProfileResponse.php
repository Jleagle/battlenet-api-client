<?php
namespace Jleagle\BattleNet\Responses\StarCraft;

use Jleagle\BattleNet\Responses\BaseResponse;

class ProfileResponse extends BaseResponse
{
  public $id;
  public $realm;
  public $displayName;
  public $clanName;
  public $clanTag;
  public $profilePath;
  public $portrait;
  public $career;
  public $swarmLevels;
  public $campaign;
  public $season;
  public $rewards;
  public $achievements;
}
