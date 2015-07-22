<?php
namespace Drupal\ide_themer\Preprocessor;


class NodePreprocessor implements PreprocessorInterface{

  const ENTITY_TYPE = 'node';

  protected $node;
  public $content;
  public $_data;

  public function __construct(&$variables) {
    $this->node = &$variables['node'];
    $this->content = &$variables['content'];
    $this->viewMode = &$variables['view_mode'];
    $this->_data = &$variables['_data'];
    $this->vars = &$variables;
  }

  public function getEntity(){
    return $this->node;

  }

  public function getEntityType( ){
    return self::ENTITY_TYPE;
  }

  public function getEntityBundle() {
    return self::ENTITY_TYPE;
  }

  public function preprocess_node__portfolio_item__listing(){

  }
} 