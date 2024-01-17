<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurityHandler;

use Drupal\Component\Utility\Crypt;
use Drupal\Core\Form\FormStateInterface;
use Drupal\tome_forms\Entity\TomeFormInterface;
use Drupal\tome_forms\Entity\TomeFormSecurityInterface;

/**
 * Uses a form token to verify form submission.
 *
 * This adds a token to the form using JavaScript, which is then verified by the
 * PHP script.
 *
 * This works as follows:
 *  1. The form's JavaScript makes an HTTP request to the PHP script.
 *  2. The PHP script responds to the GET request with a JSON array of current
 *     server timestamp and the token, which is a hash of the timestamp, the
 *     form ID, and a hash_salt. The hash salt is generated by Drupal from the
 *     Tome form entity ID during the Tome static export.
 *  3. The form's JavaScript sets these two values as hidden values in the form.
 *  4. When the form is submitted, the token is verified by the PHP script.
 *
 * The PHP script thus does double duty: for a GET request it returns the values
 * for the form, and for a POST request it handle the form submission as normal.
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
