<?php

namespace Drupal\tome_forms\Plugin\TomeFormSecurityHandler;

use Drupal\Component\Utility\Crypt;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\tome_forms\Entity\TomeFormInterface;
use Drupal\tome_forms\Entity\TomeFormSecurityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * TODO: class docs.
 *
 * @TomeFormSecurity(
 *   id = "form_token",
 *   label = @Translation("Form token"),
 * )
 */
class FormToken extends TomeFormSecurityHandlerBase implements ContainerFactoryPluginInterface {

  /**
   * The time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('datetime.time'),
    );
  }

  /**
   * Creates a FormToken instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    TimeInterface $time
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->time = $time;
  }

  protected function getFormToken(TomeFormInterface $tome_form): string {
    return 'tome_form_token-' . Crypt::hashBase64($tome_form->id() . $this->time->getRequestTime());
  }

  /**
   * {@inheritdoc}
   */
  public function formAlter(&$form, FormStateInterface $form_state, TomeFormInterface $tome_form, TomeFormSecurityInterface $tome_form_security): void {
    $form['tome_form_timestamp'] = [
      '#type' => 'token',
      '#default_value' => $this->time->getRequestTime(), // ARGH won't be the same request time as the PHP script gets!
    ];

    $form['tome_form_token'] = [
      '#type' => 'token',
      // Gets set by the JavaScript.
      '#default_value' => '',
    ];

    $form['#attached']['library'][] = 'tome_forms/form_token';
    $form['#attached']['drupalSettings']['tome_forms']['formTokenPath'] = $tome_form->getFormHandlerExportedScriptPath();
  }

  /**
   * {@inheritdoc}
   */
  public function getFormHandlerScriptSecurityCheckPhp(TomeFormInterface $tome_form, TomeFormSecurityInterface $tome_form_security): array {
    $php_lines = [];

    $form_token = $this->getFormToken($tome_form);

    $php_lines[] = '// Output the form token for a GET request used by the form JavaScript.';
    $php_lines[] = "if (\$_SERVER['REQUEST_METHOD'] === 'GET') { print '$form_token'; exit(); }";

    $php_lines[] = '// Verify the form token.';
    $php_lines[] = "if (empty(\$_POST['tome_form_token']) || \$_POST['tome_form_token'] != '$form_token' ) { redirect(); }";

    return $php_lines;
  }

}
