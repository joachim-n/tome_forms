<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurityHandler;

use Drupal\Component\Plugin\DerivativeInspectionInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\tome_forms\Entity\TomeFormInterface;
use Drupal\tome_forms\Entity\TomeFormSecurityInterface;

/**
 * Interface for Tome Form Security plugins.
 */
interface TomeFormSecurityHandlerInterface extends PluginInspectionInterface, DerivativeInspectionInterface {

  public function formAlter(&$form, FormStateInterface $form_state, TomeFormInterface $tome_form, TomeFormSecurityInterface $tome_form_security): void;

  public function getFormHandlerScriptSecurityCheckPhp(): array;

}
