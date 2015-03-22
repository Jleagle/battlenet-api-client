<?php
namespace Jleagle\BattleNet\Responses;

abstract class BaseResponse
{
  public function __construct(array $data)
  {
    foreach($data as $field => $value)
    {
      $this->$field = $value;
    }
  }

  public function toArray()
  {
    return get_object_vars($this);
  }
}
