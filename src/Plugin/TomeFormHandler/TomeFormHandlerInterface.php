<?php

namespace Drupal\tome_forms\Plugin\TomeFormHandler;

use Drupal\Component\Plugin\DerivativeInspectionInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Interface for Tome Form Handler plugins.
 */
interface TomeFormHandlerInterface extends PluginInspectionInterface, DerivativeInspectionInterface {

  public function getFormHandlerScriptPhp(): string;

}
