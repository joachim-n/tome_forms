<?php

namespace Drupal\tome_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityWithPluginCollectionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\tome_forms\Plugin\TomeFormHandler\TomeFormHandlerInterface;

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

  public function useLocalScript(): bool;

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

  public function formAlter(&$form, FormStateInterface $form_state): void;

  /**
   * Gets the path to redirect to after a successful static form submission.
   *
   * @return string
   *   A path.
   */
  public function getRedirectSuccessPath(): string;

  /**
   * Gets the path to redirect to when a static form submission is rejected.
   *
   * @return string
   *   A path.
   */
  public function getRedirectRejectPath(): string;

  /**
   * Gets the PHP code for the form handler script.
   *
   * @return string
   *   The PHP code.
   */
  public function getFormHandlerScriptPhp(): string;

  public function getFormHandlerPlugin(): TomeFormHandlerInterface;

  public function getFormSecurityHandlers(): array;

}
