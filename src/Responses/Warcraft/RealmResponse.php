<?php
namespace Jleagle\BattleNet\Responses\Warcraft;

use Jleagle\BattleNet\Responses\BaseResponse;

class RealmResponse extends BaseResponse
{
  public $type;
  public $population;
  public $queue;
  public $wintergrasp;
  public $tol_barad;
  public $status;
  public $name;
  public $slug;
  public $battlegroup;
  public $locale;
  public $timezone;
  public $connected_realms;
}
