<?php

namespace Drupal\tome_forms\Plugin\TomeFormHandler;

use Drupal\Component\Plugin\PluginBase;
use Drupal\tome_forms\Entity\TomeFormInterface;

/**
 * Base class for Tome Form Handler plugins.
 */
abstract class TomeFormHandlerBase extends PluginBase implements TomeFormHandlerInterface {

  /**
   * Gets the header for the PHP script.
   *
   * All plugins should begin their script with this code.
   *
   * This does the following:
   *  - Defines variables for:
   *    - the form ID
   *    - the plugin configuration (see self::getScriptPluginConfigurationVariables())
   *    - various other site properties TODO.
   *  - Defines a redirect() function which sends the user to the front page of
   *    the site.
   *  - Checks the form ID.
   *  - Checks security handlers.
   *
   * @return string
   *   The PHP code.
   */
  protected function getScriptHeader(TomeFormInterface $tome_form): string {
    $php_lines = [];

    $php_lines[] = '<?php';

    // Add the plugin configuration values to the script.
    $script_variables = $this->getScriptPluginConfigurationVariables();

    $script_variables['form_id'] = $tome_form->getFormId();

    // TODO: get the site mail from config.
    $script_variables['site_mail'] = 'site@example.com';

    foreach ($script_variables as $key => $value) {
      $php_lines[] = '$' . $key . ' = ' . var_export($value, TRUE) . ';';
    }

    // Helper function for redirecting.
    $redirect_path = $tome_form->getRedirectPath();
    $php_lines[] = "function redirect() { header('Location: $redirect_path'); exit(); }";

    // Verification code: form ID.
    $php_lines[] = '// Verify the form ID.';
    $php_lines[] = 'if (!isset($_POST[\'form_id\']) || ($_POST[\'form_id\'] !== $form_id)) { redirect(); }';

    // Verification code: security handlers.
    foreach ($tome_form->getFormSecurityHandlers() as $form_security_handler) {
      $php_lines = array_merge($php_lines, $form_security_handler->getFormHandlerScriptSecurityCheckPhp());
    }

    $php = implode("\n", $php_lines) . "\n";

    return $php;
  }

  /**
   * Gets the plugin's configuration values to add to the script as variables.
   *
   * WARNING: This is not very subtle and assumes each configuration value is a
   * scalar. If your plugin does something more complex, override this method to
   * massage the values.
   *
   * @return array
   *   An array whose keys are used as variable names in the PHP script, and
   *   whose values are the values for those variables, exported with
   *   var_export().
   */
  protected function getScriptPluginConfigurationVariables(): array {
    return $this->configuration ?? [];
  }

}
