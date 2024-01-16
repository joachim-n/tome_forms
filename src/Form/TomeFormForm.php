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
      '#description' => $this->t("The human-readable name of this Tome form."),
      '#default_value' => $this->entity->get('label'),
      '#required' => TRUE,
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
      '#required' => TRUE,
    ];

    // Can't call this 'form_id', it gets clobbered by FormBuilder.
    $form['tome_form_id'] = [
      '#type' => "textfield",
      '#title' => $this->t("Form ID"),
      '#description' => $this->t("The form ID of the form to export to Tome."),
      '#default_value' => $this->entity->get('form_id'),
      '#required' => TRUE,
    ];

    $form['export_paths'] = [
      '#type' => "textarea",
      '#title' => $this->t("Export paths"),
      '#description' => $this->t("Optional paths to export to Tome. One path per line, with initial '/'."),
      '#default_value' => $this->entity->get('export_paths') ? implode("\n", $this->entity->get('export_paths')) : '',
      // TODO: validate initial /.
    ];

    $form['redirect_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Redirect URL"),
      '#description' => $this->t("The URL to redirect users when the static form is submitted. Leave empty to redirect to the front page of the static site."),
      '#default_value' => $this->entity->get('redirect_path'),
      // TODO: validate initial /.
    ];

    $options = [];
    $form_security_entities = $this->entityTypeManager->getStorage('tome_form_security')->loadMultiple();
    // TODO: filter on local/remote
    foreach ($form_security_entities as $form_security_entity) {
      $options[$form_security_entity->id()] = $form_security_entity->label();
    }

    $form['security'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t("Security handling"),
      '#description' => $this->t("Select which security handling to use with this form on the static site."),
      '#options' => $options,
      '#default_value' => $this->entity->get('security'),
    ];

    $form['form_handler'] = [
      '#type' => 'tome_form_plugin',
      '#title' => $this->t('Form handler'),
      '#description' => $this->t('Determines what happens when the static version of the form is submitted.'),
      '#required' => TRUE,
      '#options_element_type' => 'radios',
      '#plugin_manager' => 'plugin.manager.tome_form_handler',
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

    $entity->set('form_id', $form_state->getValue('tome_form_id'));

    $entity->set('export_paths', explode("\n", $form_state->getValue('export_paths')));

    $entity->set('form_handler_id', $form_state->getValue(['form_handler', 'plugin_id']));
    $entity->set('form_handler_config', $form_state->getValue(['form_handler', 'plugin_configuration']) ?? []);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Only one Tome form entity can act on a particular form ID.
    $existing_tome_forms_for_form_id = $this->entityTypeManager->getStorage('tome_form')->loadByProperties([
      'form_id' => $form_state->getValue('tome_form_id'),
    ]);
    unset($existing_tome_forms_for_form_id[$this->entity->id()]);
    unset($existing_tome_forms_for_form_id[$this->entity->getOriginalId()]);
    if (count($existing_tome_forms_for_form_id)) {
      $existing = reset($existing_tome_forms_for_form_id);
      $form_state->setErrorByName('tome_form_id', $this->t("Cannot use the same form ID in more than one Tome form configuration. The form ID '@form_id' is already targetted by the %label Tome form.", [
        '@form_id' => $form_state->getValue('tome_form_id'),
        '%label' => $existing->label(),
      ]));
    }

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
