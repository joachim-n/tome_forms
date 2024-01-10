<?php

namespace Drupal\tome_forms\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the default form handler for the Tome Form entity.
 */
class TomeFormForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => "textfield",
      '#title' => $this->t("Name"),
      '#description' => $this->t("The human-readable name of this Tome form"),
      '#default_value' => $this->entity->get('label'),
    ];
    $form['id'] = [
      '#type' => "machine_name",
      '#title' => $this->t("Name"),
      '#description' => $this->t("A unique machine-readable name for this entity. It must only contain lowercase letters, numbers, and underscores."),
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => ['Drupal\tome_forms\Entity\TomeForm', 'load'],
        'source' => ['label'],
      ],
    ];
    // Can't call this 'form_id', it gets clobbered by FormBuilder.
    $form['tome_form_id'] = [
      '#type' => "textfield",
      '#title' => $this->t("Form ID"),
      '#description' => $this->t("The form ID of the form to export to Tome."),
      '#default_value' => $this->entity->get('form_id'),
    ];

    $form['form_handler'] = [
      '#type' => 'tome_form_handler_plugin',
      '#title' => $this->t('Form handler'),
      '#required' => TRUE,
      '#default_value' => [
        'plugin_id' => $this->entity->get('form_handler_id'),
        'plugin_configuration' => $this->entity->get('form_handler_config'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function copyFormValuesToEntity(EntityInterface $entity, array $form, FormStateInterface $form_state) {
    parent::copyFormValuesToEntity($entity, $form, $form_state);

    // $entity->set('plugin_id', $form_state->getValue(['plugin', 'plugin_id']));
    // $entity->set('plugin_config', $form_state->getValue(['plugin', 'plugin_configuration']) ?? []);

    // $entity->set('link_style', $form_state->getValue(['link_style']));
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
    $status = parent::save($form, $form_state);

    $t_args = ['%name' => $this->entity->label()];
    if ($status == SAVED_UPDATED) {
      $this->messenger()->addStatus($this->t('The tome form %name has been updated.', $t_args));
    }
    elseif ($status == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('The tome form %name has been added.', $t_args));
    }

    $form_state->setRedirectUrl($this->entity->toUrl('collection'));

    return $status;
  }

}
