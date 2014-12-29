<?php
namespace Jleagle\BattleNet\Responses;

class BaseResponse
{
  public function __construct(array $data)
  {
    foreach($data as $field => $value)
    {
      $this->$field = $value;
    }
  }
}
