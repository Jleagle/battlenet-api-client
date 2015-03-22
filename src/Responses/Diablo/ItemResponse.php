<?php
namespace Jleagle\BattleNet\Responses\Diablo;

use Jleagle\BattleNet\Responses\BaseResponse;

class ItemResponse extends BaseResponse
{
  public $id;
  public $name;
  public $icon;
  public $displayColor;
  public $tooltipParams;
  public $requiredLevel;
  public $itemLevel;
  public $bonusAffixes;
  public $bonusAffixesMax;
  public $accountBound;
  public $flavorText;
  public $typeName;
  public $type;
  public $slots;
  public $attributes;
  public $attributesRaw;
  public $randomAffixes;
  public $gems;
  public $socketEffects;
  public $craftedBy;
  public $description;
  public $seasonRequiredToDrop;
  public $isSeasonRequiredToDrop;
  public $jewelSecondaryEffectUnlockRank;
  public $jewelSecondaryEffectUnlock;
}
