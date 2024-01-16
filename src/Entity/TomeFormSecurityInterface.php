<?php

namespace Drupal\tome_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityWithPluginCollectionInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Interface for Tome Security entities.
 */
interface TomeFormSecurityInterface extends ConfigEntityInterface, EntityWithPluginCollectionInterface {

  public function formAlter(&$form, FormStateInterface $form_state): void;

}
