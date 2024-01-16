<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurity;

use Drupal\Core\Form\FormStateInterface;

/**
 * TODO: class docs.
 *
 * @TomeFormSecurity(
 *   id = "form_token",
 *   label = @Translation("Form token"),
 * )
 */
class FormToken extends TomeFormSecurityHandlerBase {

  protected function getFormToken(): string {
    return 'cake';
  }

  /**
   * {@inheritdoc}
   */
  public function formAlter(&$form, FormStateInterface $form_state): void {
    // ARH but JS!
    $form['tome_form_token'] = [
      '#type' => 'token',
      '#default_value' => $this->getFormToken(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormHandlerScriptSecurityCheckPhp(): array {
    $php_lines = [];

    $form_token = $this->getFormToken();

    $php_lines[] = '// Verify the form token.';
    $php_lines[] = "if (empty(\$_POST['tome_form_token']) || \$_POST['tome_form_token'] != '$form_token' ) { redirect(); }";

    return $php_lines;
  }

}
