<?php
namespace Jleagle\BattleNet\Responses\Warcraft;

use Jleagle\BattleNet\Responses\BaseResponse;

class BattlePetAbilityResponse extends BaseResponse
{
  /**
   * @var int
   */
  public $id;

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $icon;

  /**
   * @var int
   */
  public $cooldown;

  /**
   * @var int
   */
  public $rounds;

  /**
   * @var int
   */
  public $petTypeId;

  /**
   * @var bool
   */
  public $isPassive;

  /**
   * @var bool
   */
  public $hideHints;
}
