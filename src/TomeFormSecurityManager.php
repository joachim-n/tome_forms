<?php

namespace Drupal\tome_forms;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\tome_forms\Annotation\TomeFormSecurity;
use Drupal\tome_forms\Plugin\TomeFormSecurity\TomeFormSecurityInterface;

/**
 * Manages discovery and instantiation of Tome Form Security plugins.
 */
class TomeFormSecurityManager extends DefaultPluginManager {

  /**
   * Constructs a new TomeFormSecurityManagerManager.
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
      'Plugin/TomeFormSecurity',
      $namespaces,
      $module_handler,
      TomeFormSecurityInterface::class,
      TomeFormSecurity::class
    );

    $this->alterInfo('tome_form_security_info');
    $this->setCacheBackend($cache_backend, 'tome_form_security_plugins');
  }

  /**
   * {@inheritdoc}
   */
  protected function getType() {
    return 'tome_form_security';
  }

}
