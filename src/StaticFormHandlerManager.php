<?php

namespace Drupal\tome_forms;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\tome_forms\Annotation\StaticFormHandler;
use Drupal\tome_forms\Plugin\StaticFormHandler\StaticFormHandlerInterface;

/**
 * Manages discovery and instantiation of Static Form Handler plugins.
 */
class StaticFormHandlerManager extends DefaultPluginManager {

  /**
   * Constructs a new StaticFormHandlerManagerManager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   The cache backend.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(
    \Traversable $namespaces,
    CacheBackendInterface $cache_backend,
    ModuleHandlerInterface $module_handler
  ) {
    parent::__construct(
      'Plugin/StaticFormHandler',
      $namespaces,
      $module_handler,
      StaticFormHandlerInterface::class,
      StaticFormHandler::class
    );

    $this->alterInfo('static_form_handler_info');
    $this->setCacheBackend($cache_backend, 'static_form_handler_plugins');
  }

  /**
   * {@inheritdoc}
   */
  protected function getType() {
    return 'static_form_handler';
  }

}
