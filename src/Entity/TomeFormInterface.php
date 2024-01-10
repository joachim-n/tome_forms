<?php

namespace Drupal\tome_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityWithPluginCollectionInterface;

/**
 * Interface for Tome Form entities.
 */
interface TomeFormInterface extends ConfigEntityInterface, EntityWithPluginCollectionInterface {

  public function getFormId(): string;

  public function getFormHandlerExportedScriptPath(): string;

  public function getExportPaths(): array;

  public function getFormHandlerScriptPhp(): string;

}
