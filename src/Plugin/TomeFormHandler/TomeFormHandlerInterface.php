<?php

namespace Drupal\tome_forms\Plugin\TomeFormHandler;

use Drupal\Component\Plugin\DerivativeInspectionInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\tome_forms\Entity\TomeFormInterface;

/**
 * Interface for Tome Form Handler plugins.
 */
interface TomeFormHandlerInterface extends PluginInspectionInterface, DerivativeInspectionInterface {

  /**
   * Gets whether this plugin uses a local PHP script for form submission.
   *
   * @return boolean
   */
  public function hasLocalScript(): bool;

  /**
   * Gets the PHP code for the form handler script.
   *
   * All plugins should begin their script with getScriptHeader(), which takes
   * care of form security, and defines useful variables.
   *
   * @param \Drupal\tome_forms\Entity\TomeFormInterface $tome_form
   *   The Tome form entity.
   *
   * @return string
   *   The PHP code to write to the script file as part of the Tome export.
   */
  public function getFormHandlerScriptPhp(TomeFormInterface $tome_form): string;

}
