<?php
namespace Jleagle\BattleNet\Responses\Community;

use Jleagle\BattleNet\Responses\BaseResponse;

class WarcraftCharacterResponse extends BaseResponse
{
  public $name;
  public $realm;
  public $battlegroup;
  public $class;
  public $race;
  public $gender;
  public $level;
  public $achievementPoints;
  public $thumbnail;
  public $spec;
  public $guild;
  public $guildRealm;
}
