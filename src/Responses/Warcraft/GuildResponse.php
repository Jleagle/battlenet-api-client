<?php
namespace Jleagle\BattleNet\Responses\Warcraft;

use Jleagle\BattleNet\Responses\BaseResponse;

class GuildResponse extends BaseResponse
{
  public $lastModified;
  public $name;
  public $realm;
  public $battlegroup;
  public $level;
  public $side;
  public $achievementPoints;
  public $achievements;
  public $members;
  public $emblem;
  public $news;
  public $challenge;
}
