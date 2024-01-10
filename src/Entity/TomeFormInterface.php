<?php

namespace Drupal\tome_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityWithPluginCollectionInterface;

/**
 * Interface for Tome Form entities.
 */
interface TomeFormInterface extends ConfigEntityInterface, EntityWithPluginCollectionInterface {

  /**
   * Gets the ID of the form this entity handles.
   *
   * @return string
   *   The form ID.
   */
  public function getFormId(): string;

  /**
   * Gets the relative path for the static export form to submit to.
   *
   * @return string
   *   The path, relative to the domain of the static export. Note that Tome
   *   static exports do not in general work in a subfolder.
   */
  public function getFormHandlerExportedScriptPath(): string;

  /**
   * Gets any additional paths to export with Tome.
   *
   * @return array
   *   An array of paths.
   */
  public function getExportPaths(): array;

  /**
   * Gets the PHP code for the form handler script.
   *
   * @return string
   *   The PHP code.
   */
  public function getFormHandlerScriptPhp(): string;

}
