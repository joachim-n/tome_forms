<?php

namespace Drupal\tome_forms\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines the Tome Form Handler plugin annotation object.
 *
 * Plugin namespace: TomeFormHandler.
 *
 * @Annotation
 */
class TomeFormHandler extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id = '';

  /**
   * The human-readable name of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label = '';

}
