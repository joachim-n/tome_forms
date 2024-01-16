<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurity;

/**
 * TODO: class docs.
 *
 * @TomeFormSecurity(
 *   id = "tome_forms_honey_pot",
 *   label = @Translation("Honey Pot"),
 * )
 */
class HoneyPot extends TomeFormSecurityBase {

  public function getFormHandlerScriptSecurityCheckPhp(): array {
    $php_lines = [];

    $php_lines[] = '// Verify the honeypot.';
    $php_lines[] = 'if (!empty($_POST[\'h_mail\'])) { redirect(); }';

    return $php_lines;
  }

}
