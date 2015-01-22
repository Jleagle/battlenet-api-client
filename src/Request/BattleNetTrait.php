<?php
namespace Jleagle\BattleNet\Request;

trait BattleNetTrait
{
  protected $_jsonP;
  protected $_serverLocation;

  public function setJsonp($callback)
  {
    $this->_jsonP = $callback;
  }

  /**
   * @param string $path
   *
   * @return string
   */
  private function _makeApiUrl($path)
  {
    return 'https://' . $this->_serverLocation . '.api.battle.net/' . $path;
  }
}
