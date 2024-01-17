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

  /**
   * {@inheritdoc}
   */
  public function formAlter(&$form, FormStateInterface $form_state, TomeFormInterface $tome_form, TomeFormSecurityInterface $tome_form_security): void {
    $form['tome_form_token'] = [
      '#type' => 'token',
      // Gets set by the JavaScript.
      '#default_value' => '',
    ];

    $form['#attached']['library'][] = 'tome_forms/form_token';
    $form['#attached']['drupalSettings']['tome_forms']['formTokenPath'] = $tome_form->getFormHandlerExportedScriptPath();
  }

  /**
   * {@inheritdoc}
   */
  public function getFormHandlerScriptSecurityCheckPhp(TomeFormInterface $tome_form, TomeFormSecurityInterface $tome_form_security): array {
    $php_lines = [];

    $form_id = $tome_form->getFormId();

    $php_lines[] = "\$form_token = base64_encode(hash('sha256', '$form_id', TRUE));";
    $php_lines[] = '// Output the form token for a GET request used by the form JavaScript.';
    $php_lines[] = "if (\$_SERVER['REQUEST_METHOD'] === 'GET') { print json_encode(['token' => \$form_token, 'timestamp' => time()]); exit(); }";

    $php_lines[] = '// Verify the form token.';
    $php_lines[] = "if (empty(\$_POST['tome_form_token']) || \$_POST['tome_form_token'] != \$form_token ) { redirect(); }";

    return $php_lines;
  }

}
