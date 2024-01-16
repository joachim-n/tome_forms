<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurity;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Base class for Tome Form Security plugins.
 */
abstract class TomeFormSecurityBase extends PluginBase implements TomeFormSecurityInterface {

  public function formAlter(&$form, FormStateInterface $form_state): void {
  }

  // or only on local???
  public function getFormHandlerScriptSecurityCheckPhp(): array {
    return [];
  }
}
