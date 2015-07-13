<?php
namespace Drupal\ide_themer\Dispatcher;

use Drupal\ide_themer\Preprocessor\PreprocessorInterface;

class Dispatcher {

  protected $preprocessor;

  public function __construct(PreprocessorInterface $preprocessor) {
    $this->preprocessor = $preprocessor;
  }

  public function dispatch() {
    $entity = $this->preprocessor->getEntity();
    $entityType = $entity->getEntityTypeId();
    $viewMode = $this->preprocessor->viewMode;
    $bundle = $entity->bundle();

    $method = 'preprocess_' . $entityType . '__' . $bundle . '__' . $viewMode;
    if (method_exists($this->preprocessor, $method)) {
      $this->preprocessor->{$method}();
    }

  }

} 