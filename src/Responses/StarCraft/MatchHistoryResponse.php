<?php
namespace Jleagle\BattleNet\Responses\StarCraft;

use Jleagle\BattleNet\Responses\BaseResponse;

class MatchHistoryResponse extends BaseResponse
{
  public $map;
  public $type;
  public $decision;
  public $speed;
  public $date;
}
