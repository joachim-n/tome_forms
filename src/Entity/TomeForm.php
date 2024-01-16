<?php

namespace Drupal\tome_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Plugin\DefaultSingleLazyPluginCollection;
use Drupal\tome_forms\Plugin\TomeFormHandler\TomeFormHandlerInterface;

/**
 * Provides the Tome Form entity.
 *
 * @ConfigEntityType(
 *   id = "tome_form",
 *   label = @Translation("Tome form"),
 *   label_collection = @Translation("Tome forms"),
 *   label_singular = @Translation("tome form"),
 *   label_plural = @Translation("tome forms"),
 *   label_count = @PluralTranslation(
 *     singular = "@count tome form",
 *     plural = "@count tome forms",
 *   ),
 *   handlers = {
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *     "form" = {
 *       "default" = "Drupal\tome_forms\Form\TomeFormForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\tome_forms\Entity\Handler\TomeFormListBuilder",
 *   },
 *   admin_permission = "administer tome_form entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "form_id",
 *     "export_paths",
 *     "redirect_path",
 *     "security",
 *     "form_handler_id",
 *     "form_handler_config",
 *   },
 *   links = {
 *     "add-form" = "/admin/config/tome/static/tome_form/add",
 *     "canonical" = "/admin/config/tome/static/tome_form/{tome_form}",
 *     "collection" = "/admin/config/tome/static/tome_form",
 *     "edit-form" = "/admin/config/tome/static/tome_form/{tome_form}/edit",
 *     "delete-form" = "/admin/config/tome/static/tome_form/{tome_form}/delete",
 *   },
 * )
 */
class TomeForm extends ConfigEntityBase implements TomeFormInterface {

  /**
   * Machine name.
   *
   * @var string
   */
  protected $id = '';

  /**
   * Name.
   *
   * @var string
   */
  protected $label = '';

  /**
   * Form Id.
   *
   * @var string
   */
  protected $form_id = '';

  /**
   * A list of paths to export with Tome.
   *
   * @var array
   */
  protected $export_paths = [];

  /**
   * The path to redirect the user to on submission of the static form.
   *
   * @var string
   */
  protected $redirect_path = '';

  /**
   * The tome form security to use with this form.
   *
   * An array of tome form security config entity IDs.
   *
   * @var array
   */
  protected $security = [];

  /**
   * The ID of the form handler plugin this form uses for static submission.
   *
   * @var string
   */
  protected $form_handler_id = '';

  /**
   * The configuration for the form handler plugin.
   *
   * @var array
   */
  protected $form_handler_config = [];

  /**
   * The plugin collection that holds the form handler plugin.
   *
   * @var \Drupal\Core\Plugin\DefaultSingleLazyPluginCollection
   */
  protected $pluginCollection;

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return $this->form_id;
  }

  /**
   * {@inheritdoc}
   */
  public function getExportPaths(): array {
    return $this->export_paths;
  }

  /**
   * {@inheritdoc}
   */
  public function getRedirectPath(): string {
    // Default to the front page if the property is empty.
    return $this->redirect_path ?: '/';
  }

  /**
   * {@inheritdoc}
   */
  public function getFormHandlerExportedScriptPath(): string {
    // TODO: build this with the Url class and the route name!
    return '/tome-form-handler/' . $this->id() . '.php';
  }

  /**
   * {@inheritdoc}
   */
  public function getFormHandlerScriptPhp(): string {
    return $this->getFormHandlerPlugin()->getFormHandlerScriptPhp($this);
  }

  /**
   * {@inheritdoc}
   */
  public function getFormHandlerPlugin(): TomeFormHandlerInterface {
    return $this->getTomeFormHandlerCollection()->get($this->form_handler_id);
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginCollections() {
    $collections = [];
    if ($collection = $this->getTomeFormHandlerCollection()) {
      $collections['form_handler'] = $collection;
    }
    return $collections;
  }

  /**
   * Gets the plugin collection for the form handler plugin.
   */
  protected function getTomeFormHandlerCollection() {
    if (!$this->pluginCollection && $this->form_handler_id) {
      $plugin_manager = \Drupal::service('plugin.manager.tome_form_handler');
      $this->pluginCollection = new DefaultSingleLazyPluginCollection(
        $plugin_manager,
        $this->form_handler_id,
        $this->form_handler_config,
      );
    }
    return $this->pluginCollection;
  }

}
