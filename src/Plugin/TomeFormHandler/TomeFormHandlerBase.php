<?php

namespace Drupal\tome_forms\Plugin\TomeFormHandler;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for Tome Form Handler plugins.
 */
abstract class TomeFormHandlerBase extends PluginBase implements TomeFormHandlerInterface {

  // TODO docs
  protected function getScriptHeader(): string {
    $php_lines = [];

    $php_lines[] = '<?php';

    // Add the plugin configuration values to the script.
    // WARNING: This is not very subtle and assumes each configuration setting
    // is a scalar!
    $script_variables = $this->configuration ?? [];

    // TODO: get the site mail from config.
    $script_variables['site_mail'] = 'site@example.com';

    foreach ($script_variables as $key => $value) {
      $php_lines[] = '$' . $key . ' = ' . var_export($value, TRUE) . ';';
    }

    return implode("\n", $php_lines) . "\n";
  }

}
