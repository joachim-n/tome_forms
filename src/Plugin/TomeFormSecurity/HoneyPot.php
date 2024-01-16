<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurity;

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

  public function getFormHandlerScriptSecurityCheckPhp(): array {
    $php_lines = [];

    $php_lines[] = '// Verify the honeypot.';
    $php_lines[] = 'if (!empty($_POST[\'h_mail\'])) { redirect(); }';

    return $php_lines;
  }

}
