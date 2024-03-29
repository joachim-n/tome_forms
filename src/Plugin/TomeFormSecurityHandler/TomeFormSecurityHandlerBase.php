<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurityHandler;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\tome_forms\Entity\TomeFormInterface;
use Drupal\tome_forms\Entity\TomeFormSecurityInterface;

/**
 * Base class for Tome Form Security plugins.
 */
abstract class TomeFormSecurityHandlerBase extends PluginBase implements TomeFormSecurityHandlerInterface {

  /**
   * {@inheritdoc}
   */
  public function formAlter(&$form, FormStateInterface $form_state, TomeFormInterface $tome_form, TomeFormSecurityInterface $tome_form_security): void {
  }

  /**
   * {@inheritdoc}
   */
  public function getFormHandlerScriptSecurityCheckPhp(TomeFormInterface $tome_form, TomeFormSecurityInterface $tome_form_security): array {
    return [];
  }

}
