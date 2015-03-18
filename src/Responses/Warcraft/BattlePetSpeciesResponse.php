<?php
namespace Jleagle\BattleNet\Responses\Warcraft;

use Jleagle\BattleNet\Responses\BaseResponse;

class BattlePetSpeciesResponse extends BaseResponse
{
  public $speciesId;
  public $petTypeId;
  public $creatureId;
  public $name;
  public $canBattle;
  public $icon;
  public $description;
  public $source;
  public $abilities;
}
