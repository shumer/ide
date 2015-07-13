<?php
namespace Drupal\ide_themer\Preprocessor;


class NodePreprocessor implements PreprocessorInterface{

  protected $node;
  public $content;
  public $_data;

  public function __construct(&$variables) {
    $this->node = &$variables['node'];
  }

  public function getEntity(){
    return $this->node;
  }

  public function getEntityType(){

  }

} 