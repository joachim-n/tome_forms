<?php

namespace Drupal\tome_forms;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\tome_forms\Annotation\TomeFormHandler;
use Drupal\tome_forms\Plugin\TomeFormHandler\TomeFormHandlerInterface;

/**
 * Manages discovery and instantiation of Tome Form Handler plugins.
 */
class TomeFormHandlerManager extends DefaultPluginManager {

  /**
   * Constructs a new TomeFormHandlerManagerManager.
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
      'Plugin/TomeFormHandler',
      $namespaces,
      $module_handler,
      TomeFormHandlerInterface::class,
      TomeFormHandler::class
    );

    $this->alterInfo('tome_form_handler_info');
    $this->setCacheBackend($cache_backend, 'tome_form_handler_plugins');
  }

  /**
   * {@inheritdoc}
   */
  protected function getType() {
    return 'tome_form_handler';
  }

}
