<?php

namespace Drupal\tome_forms\Plugin\TomeFormHandler;

use Drupal\Component\Plugin\ConfigurableInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\tome_forms\Entity\TomeFormInterface;

/**
 * Form handler for sending the form data in an email.
 *
 * Heavily inspired by the static_site_contact_form module
 * (https://www.drupal.org/project/static_site_contact_form).
 *
 * @todo Remove methods for ConfigurableInterface when
 * https://www.drupal.org/project/drupal/issues/2852463 gets in.
 *
 * @TomeFormHandler(
 *   id = "mail",
 *   label = @Translation("Mail"),
 *   description = @Translation("Sends an email containing the form data."),
 *   local_script = TRUE,
 * )
 */
class Mail extends TomeFormHandlerBase implements ConfigurableInterface, PluginFormInterface {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'mailto' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration) {
    // Merge in default configuration.
    $this->configuration = $configuration + $this->defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $element, FormStateInterface $form_state) {
    $element['mailto'] = [
      '#type' => 'email',
      '#title' => $this->t("Address to e-mail the form submission."),
      '#required' => TRUE,
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function getFormHandlerScriptPhp(TomeFormInterface $tome_form): string {
    $php = $this->getScriptHeader($tome_form);

    // TODO! this script is too specific to the old contact form!

    $php .= <<<'EOPHP'
      $cc = ''; // TODO

      $form_submitter = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // this is the sender's Email address
      $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $subject = "Form submission on " . $_POST['host'];
      $message = $name . " wrote the following:" . "\n\n" . filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $headers = [
        'From: ' . $site_mail,
        'Cc: ' . $cc,
        'Reply-To: ' . $form_submitter,
      ];
      // Send email to yourself, with form values.
      mail($mailto,$subject,$message,implode("\r\n", $headers));

      if ($_POST['send_copy']) {
        // Prepare a copy to send to the submitter of the form.
        $subject2 = "Copy of your form submission";
        $message2 = $name . " here is a copy of your message: \n\n" . $_POST['message'];
        $headers2 = "From:" . $mailto;
        mail($form_submitter,$subject2,$message2,$headers2);
      }

      // Redirect back to site.
      redirect();
      EOPHP;

    return $php;
  }

}
