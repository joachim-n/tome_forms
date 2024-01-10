<?php

namespace Drupal\tome_forms\Plugin\TomeFormHandler;

use Drupal\Component\Plugin\DerivativeInspectionInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\tome_forms\Entity\TomeFormInterface;

/**
 * Interface for Tome Form Handler plugins.
 */
interface TomeFormHandlerInterface extends PluginInspectionInterface, DerivativeInspectionInterface {

  /**
   * Undocumented function
   *
   * TODO: all scripts get these vars provided they use HELPER TODO
   *  form_id
   *
   * @param \Drupal\tome_forms\Entity\TomeFormInterface $tome_form
   * @return string
   */
  public function getFormHandlerScriptPhp(TomeFormInterface $tome_form): string;

}
