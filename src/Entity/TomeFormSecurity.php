<?php

namespace Drupal\tome_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\DefaultSingleLazyPluginCollection;
use Drupal\tome_forms\Plugin\TomeFormSecurityHandler\TomeFormSecurityBase;
use Drupal\tome_forms\Plugin\TomeFormSecurityHandler\TomeFormSecurityHandlerInterface;

/**
 * Provides the Tome Form Security entity.
 *
 * @ConfigEntityType(
 *   id = "tome_form_security",
 *   label = @Translation("Tome security"),
 *   label_collection = @Translation("Tome security handlers"),
 *   label_singular = @Translation("tome security"),
 *   label_plural = @Translation("tome security handlers"),
 *   label_count = @PluralTranslation(
 *     singular = "@count tome security",
 *     plural = "@count tome securitys",
 *   ),
 *   handlers = {
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *     "form" = {
 *       "default" = "Drupal\tome_forms\Form\TomeFormSecurityForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\tome_forms\Entity\Handler\TomeFormSecurityListBuilder",
 *   },
 *   admin_permission = "administer tome_form_security entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "security_plugin_id",
 *     "security_plugin_config",
 *   },
 *   links = {
 *     "add-form" = "/admin/config/tome/static/tome_form_security/add",
 *     "canonical" = "/admin/config/tome/static/tome_form_security/{tome_form_security}",
 *     "collection" = "/admin/config/tome/static/tome_form_security",
 *     "edit-form" = "/admin/config/tome/static/tome_form_security/{tome_form_security}/edit",
 *     "delete-form" = "/admin/config/tome/static/tome_form_security/{tome_form_security}/delete",
 *   },
 * )
 */
class TomeFormSecurity extends ConfigEntityBase implements TomeFormSecurityInterface {

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

  protected $security_plugin_id = '';

  protected $security_plugin_config = [];

  /**
   * The plugin collection that holds the security plugin.
   *
   * @var \Drupal\Core\Plugin\DefaultSingleLazyPluginCollection
   */
  protected $pluginCollection;

  public function formAlter(&$form, FormStateInterface $form_state, TomeFormInterface $tome_form): void {
    $this->getFormSecurityHandlerPlugin()->formAlter($form, $form_state, $tome_form, $this);
  }

  public function getFormHandlerScriptSecurityCheckPhp(TomeFormInterface $tome_form): array {
    return $this->getFormSecurityHandlerPlugin()->getFormHandlerScriptSecurityCheckPhp($tome_form, $this);
  }

  /**
   * {@inheritdoc}
   */
  public function getFormSecurityHandlerPlugin(): TomeFormSecurityHandlerInterface {
    return $this->getTomeFormSecurityCollection()->get($this->security_plugin_id);
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginCollections() {
    $collections = [];
    if ($collection = $this->getTomeFormSecurityCollection()) {
      $collections['security'] = $collection;
    }
    return $collections;
  }

  /**
   * Gets the plugin collection for the form handler plugin.
   */
  protected function getTomeFormSecurityCollection() {
    if (!$this->pluginCollection && $this->security_plugin_id) {
      $plugin_manager = \Drupal::service('plugin.manager.tome_form_security');
      $this->pluginCollection = new DefaultSingleLazyPluginCollection(
        $plugin_manager,
        $this->security_plugin_id,
        $this->security_plugin_config,
      );
    }
    return $this->pluginCollection;
  }

}
