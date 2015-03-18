<?php
namespace Jleagle\BattleNet\Responses\Warcraft;

use Jleagle\BattleNet\Responses\BaseResponse;

class SpellResponse extends BaseResponse
{
  public $id;
  public $name;
  public $icon;
  public $description;
  public $range;
  public $powerCost;
  public $castTime;
  public $cooldown;
}
