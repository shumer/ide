<?php
namespace Drupal\ide_themer\Preprocessor;


class BlockPreprocessor {

  const ENTITY_TYPE = 'block';

  public $content;
  public $_data;
  public $elements;

  public function __construct(&$variables) {

    $this->elements = &$variables['elements'];
    $this->content = &$variables['content'];
    $this->_data = &$variables['_data'];

  }


  public function preprocess() {
    $method = 'preprocess_block__' . $this->elements['#id'];
    if (method_exists($this, $method)) {
      $this->{$method}();
    }
  }

  public function preprocess_block__views_block__site_list_portfolio_item_portfolio_block() {

    $types = [];
    $results = views_get_view_result('site_query_project_types_with_content');
    foreach($results as $item) {
      $type['name'] = $item->_entity->getName();
      $type['id'] = $item->_entity->id();

      $types[] = $type;
    }
    $this->_data['types'] = $types;
  }

} 