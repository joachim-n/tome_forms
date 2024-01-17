<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurityHandler;

use Drupal\Core\Form\FormStateInterface;
use Drupal\tome_forms\Entity\TomeFormInterface;
use Drupal\tome_forms\Entity\TomeFormSecurityInterface;

/**
 * Adds a honeypot form element.
 *
 * This is hidden with CSS and verified by the local PHP script.
 *
 * @TomeFormSecurity(
 *   id = "honey_pot",
 *   label = @Translation("Honey pot"),
 *   description = @Translation("Adds a hidden honeypot element to the form."),
 * )
 */
class HoneyPot extends TomeFormSecurityHandlerBase {

  /**
   * {@inheritdoc}
   */
  public function formAlter(&$form, FormStateInterface $form_state, TomeFormInterface $tome_form, TomeFormSecurityInterface $tome_form_security): void {
    // Since captcha might be bypassed without JS, and Drupal will not be there
    // to validate the submission, we add a honeypot inspired element which we
    // hide with CSS and evaluate on the action script.
    $form['h_mail'] = [
      '#type' => 'email',
      '#title' => t('Verify email (only enter this if you are not human'),
    ];

    // Hides the honeypot element.
    $form['#attached']['library'][] = 'tome_forms/honey_pot';
  }

  /**
   * {@inheritdoc}
   */
  public function getFormHandlerScriptSecurityCheckPhp(TomeFormInterface $tome_form, TomeFormSecurityInterface $tome_form_security): array {
    $php_lines = [];

    $php_lines[] = '// Verify the honeypot.';
    $php_lines[] = 'if (!empty($_POST[\'h_mail\'])) { redirect(); }';

    return $php_lines;
  }

}
