<?php
namespace Jleagle\BattleNet\Enums;

class BaseEnum
{
  public static function toArray()
  {
    $reflection = new \ReflectionClass(new static);
    return $reflection->getConstants();
  }
}
