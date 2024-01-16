<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurity;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for Tome Form Security plugins.
 */
abstract class TomeFormSecurityBase extends PluginBase implements TomeFormSecurityInterface {

  // or only on local???
  public function getFormHandlerScriptSecurityCheckPhp(): array {
    return [];
  }
}
