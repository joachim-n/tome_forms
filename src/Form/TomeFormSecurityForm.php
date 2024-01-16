<?php

namespace Drupal\tome_forms\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the default form handler for the Tome Security entity.
 */
class TomeFormSecurityForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => "textfield",
      '#title' => $this->t("Name"),
      '#description' => $this->t("The human-readable name of this entity"),
      '#default_value' => $this->entity->get('label'),
    ];
    $form['id'] = [
      '#type' => "machine_name",
      '#title' => $this->t("Name"),
      '#description' => $this->t("A unique machine-readable name for this entity. It must only contain lowercase letters, numbers, and underscores."),
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => ['Drupal\tome_forms\Entity\TomeSecurity', 'load'],
        'source' => ['label'],
      ],
    ];

    $form['security'] = [
      '#type' => 'tome_form_plugin',
      '#title' => $this->t('Security handler'),
      '#description' => $this->t('The type of security handler to use.'),
      '#required' => TRUE,
      '#options_element_type' => 'radios',
      '#plugin_manager' => 'plugin.manager.tome_form_security',
      '#default_value' => [
        'plugin_id' => $this->entity->get('security_plugin_id'),
        'plugin_configuration' => $this->entity->get('security_plugin_config'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function copyFormValuesToEntity(EntityInterface $entity, array $form, FormStateInterface $form_state) {
    parent::copyFormValuesToEntity($entity, $form, $form_state);

    $entity->set('security_plugin_id', $form_state->getValue(['security', 'plugin_id']));
    $entity->set('security_plugin_config', $form_state->getValue(['security', 'plugin_configuration']) ?? []);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $saved = parent::save($form, $form_state);
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));

    return $saved;
  }

}
