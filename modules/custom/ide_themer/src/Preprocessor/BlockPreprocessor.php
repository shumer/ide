<?php
namespace Drupal\ide_themer\Preprocessor;


class BlockPreprocessor implements PreprocessorInterface{

  const ENTITY_TYPE = 'paragraph';

  protected $block;
  public $content;
  public $viewMode;
  public $_data;

  public function __construct(&$variables) {

    $this->block = &$variables['block'];
    $this->content = &$variables['content'];
    $this->viewMode = &$variables['view_mode'];
    $this->_data = &$variables['_data'];

  }

  public function getEntity() {
    return $this->block;
  }

  public function getEntityType( ){
    return self::ENTITY_TYPE;
  }

  public function getEntityBundle() {
    return self::ENTITY_TYPE;
  }

  public function preprocess_block__worthyservices__default() {

  }

} 