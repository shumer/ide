<?php
namespace Drupal\ide_themer\Preprocessor;


class ParagraphPreprocessor implements PreprocessorInterface{

  const ENTITY_TYPE = 'paragraph';

  protected $paragraph;
  public $content;
  public $viewMode;
  public $_data;

  public function __construct(&$variables) {

    $this->paragraph = &$variables['paragraph'];
    $this->content = &$variables['content'];
    $this->viewMode = &$variables['view_mode'];
    $this->_data = &$variables['_data'];

  }

  public function getEntity() {
    return $this->paragraph;
  }

  public function getEntityType( ){
    return self::ENTITY_TYPE;
  }

  public function getEntityBundle() {
    return self::ENTITY_TYPE;
  }

  public function preprocess_paragraph__frontpage_feature_tab__default() {

  }

} 