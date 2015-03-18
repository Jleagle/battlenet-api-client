<?php
namespace Jleagle\BattleNet\Responses\Warcraft;

use Jleagle\BattleNet\Responses\BaseResponse;

class QuestResponse extends BaseResponse
{
  public $id;
  public $title;
  public $reqLevel;
  public $suggestedPartyMembers;
  public $category;
  public $level;
}
