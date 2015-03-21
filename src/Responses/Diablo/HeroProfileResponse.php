<?php
namespace Jleagle\BattleNet\Responses\Diablo;

use Jleagle\BattleNet\Responses\BaseResponse;

class HeroProfileResponse extends BaseResponse
{
  public $id;
  public $name;
  public $class;
  public $gender;
  public $level;
  public $paragonLevel;
  public $hardcore;
  public $seasonal;
  public $seasonCreated;
  public $skills;
  public $items;
  public $followers;
  public $stats;
  public $kills;
  public $progression;
}
