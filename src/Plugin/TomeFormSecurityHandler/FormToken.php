<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurityHandler;

use Drupal\Component\Utility\Crypt;
use Drupal\Core\Form\FormStateInterface;
use Drupal\tome_forms\Entity\TomeFormInterface;
use Drupal\tome_forms\Entity\TomeFormSecurityInterface;

/**
 * TODO: class docs.
 *
 * @TomeFormSecurity(
 *   id = "form_token",
 *   label = @Translation("Form token"),
 * )
 */
class FormToken extends TomeFormSecurityHandlerBase {

  protected function getFormToken(TomeFormInterface $tome_form): string {
    // TODO: include timestamp.
    return 'tome_form_token-' . Crypt::hashBase64($tome_form->id());
  }

  /**
   * {@inheritdoc}
   */
  public function formAlter(&$form, FormStateInterface $form_state, TomeFormInterface $tome_form, TomeFormSecurityInterface $tome_form_security): void {
    // ARH but JS!
    $form['tome_form_token'] = [
      '#type' => 'token',
      '#default_value' => $this->getFormToken($tome_form),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormHandlerScriptSecurityCheckPhp(TomeFormInterface $tome_form, TomeFormSecurityInterface $tome_form_security): array {
    $php_lines = [];

    $form_token = $this->getFormToken($tome_form);

    $php_lines[] = '// Verify the form token.';
    $php_lines[] = "if (empty(\$_POST['tome_form_token']) || \$_POST['tome_form_token'] != '$form_token' ) { redirect(); }";

    return $php_lines;
  }

}
