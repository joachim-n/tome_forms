<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurity;

use Drupal\Component\Plugin\DerivativeInspectionInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Interface for Tome Form Security plugins.
 */
interface TomeFormSecurityInterface extends PluginInspectionInterface, DerivativeInspectionInterface {

  public function formAlter(&$form, FormStateInterface $form_state): void;

  public function getFormHandlerScriptSecurityCheckPhp(): array;

}
