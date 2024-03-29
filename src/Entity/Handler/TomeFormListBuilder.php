<?php

namespace Drupal\tome_forms\Entity\Handler;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides the list builder handler for the Tome Form entity.
 */
class TomeFormListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header = [];
    $header['name'] = $this->t('Name');
    $header['form_id'] = $this->t('Form ID');
    $header['form_handler'] = $this->t('Form handler');
    $header['form_security'] = $this->t('Form security');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row = [];
    /** @var \Drupal\tome_forms\Entity\TomeFormInterface $entity */
    $row['name'] = $entity->label();
    $row['form_id'] = $entity->getFormId();
    $row['form_handler'] = $entity->getFormHandlerPlugin()->getPluginDefinition()['label'];
    $row['form_security'] = implode(', ', array_map(fn ($form_security) => $form_security->label(), $entity->getFormSecurityHandlers()));
    return $row + parent::buildRow($entity);
  }

}
