<?php

namespace Drupal\tome_forms\Plugin\TomeFormHandler;

use Drupal\Component\Plugin\PluginBase;
use Drupal\tome_forms\Entity\TomeFormInterface;

/**
 * Base class for Tome Form Handler plugins.
 */
abstract class TomeFormHandlerBase extends PluginBase implements TomeFormHandlerInterface {

  // TODO docs
  protected function getScriptHeader(TomeFormInterface $tome_form): string {
    $php_lines = [];

    $php_lines[] = '<?php';

    // Add the plugin configuration values to the script.
    // WARNING: This is not very subtle and assumes each configuration setting
    // is a scalar!
    // TODO move this bit to another helper method so it can be overridden.
    $script_variables = $this->configuration ?? [];

    $script_variables['form_id'] = $tome_form->getFormId();

    // TODO: get the site mail from config.
    $script_variables['site_mail'] = 'site@example.com';

    foreach ($script_variables as $key => $value) {
      $php_lines[] = '$' . $key . ' = ' . var_export($value, TRUE) . ';';
    }

    return implode("\n", $php_lines) . "\n";
  }

}
