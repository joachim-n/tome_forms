<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurity;

use Drupal\Core\Form\FormStateInterface;

/**
 * Adds a honeypot form element.
 *
 * This is hidden with CSS and verified by the local PHP script.
 *
 * @TomeFormSecurity(
 *   id = "honey_pot",
 *   label = @Translation("Honey Pot"),
 * )
 */
class HoneyPot extends TomeFormSecurityBase {

  public function formAlter(&$form, FormStateInterface $form_state): void {
    // Since captcha might be bypassed without JS, and Drupal will not be there
    // to validate the submission, we add a honeypot inspired element which we
    // hide with CSS and evaluate on the action script.
    $form['h_mail'] = [
      '#type' => 'email',
      '#title' => t('Verify email (only enter this if you are not human'),
    ];

    // Hides the honeypot element.
    $form['#attached']['library'] = 'tome_forms/tome_forms';
  }

  public function getFormHandlerScriptSecurityCheckPhp(): array {
    $php_lines = [];

    $php_lines[] = '// Verify the honeypot.';
    $php_lines[] = 'if (!empty($_POST[\'h_mail\'])) { redirect(); }';

    return $php_lines;
  }

}
