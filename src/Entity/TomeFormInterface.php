<?php

namespace Drupal\tome_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityWithPluginCollectionInterface;

/**
 * Interface for Tome Form entities.
 */
interface TomeFormInterface extends ConfigEntityInterface, EntityWithPluginCollectionInterface {

  public function getPaths(): array;

}
