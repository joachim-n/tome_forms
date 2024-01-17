<?php

namespace Drupal\tome_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityWithPluginCollectionInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Interface for Tome Security entities.
 */
interface TomeFormSecurityInterface extends ConfigEntityInterface, EntityWithPluginCollectionInterface {

  /**
   * Alters the form.
   *
   * @param array $form
   *   The form build array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   * @param TomeFormInterface $tome_form
   *   The Tome form entity.
   */
  public function formAlter(&$form, FormStateInterface $form_state, TomeFormInterface $tome_form): void;

}
