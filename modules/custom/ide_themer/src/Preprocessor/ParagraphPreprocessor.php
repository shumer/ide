<?php
namespace Drupal\ide_themer\Preprocessor;

use Drupal\Component\Utility\SafeMarkup;

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
    $this->vars = &$variables;

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

  public function preprocess_paragraph__service_item__default() {

  }

  public function preprocess_paragraph__code__default() {
    $this->_data['class'] = SafeMarkup::checkPlain($this->paragraph->field_paragraph_code_lang->value);
  }
}
