<?php

namespace Drupal\tome_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Plugin\DefaultSingleLazyPluginCollection;

/**
 * Provides the Tome Security entity.
 *
 * @ConfigEntityType(
 *   id = "tome_security",
 *   label = @Translation("Tome Security"),
 *   label_collection = @Translation("Tome Securitys"),
 *   label_singular = @Translation("tome security"),
 *   label_plural = @Translation("tome securitys"),
 *   label_count = @PluralTranslation(
 *     singular = "@count tome security",
 *     plural = "@count tome securitys",
 *   ),
 *   handlers = {
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *     "form" = {
 *       "default" = "Drupal\tome_forms\Form\TomeSecurityForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\tome_forms\Entity\Handler\TomeSecurityListBuilder",
 *   },
 *   admin_permission = "administer tome_security entities",
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
 *     "add-form" = "/admin/config/tome/static/tome_security/add",
 *     "canonical" = "/admin/config/tome/static/tome_security/{tome_security}",
 *     "collection" = "/admin/config/tome/static/tome_security",
 *     "edit-form" = "/admin/config/tome/static/tome_security/{tome_security}/edit",
 *     "delete-form" = "/admin/config/tome/static/tome_security/{tome_security}/delete",
 *   },
 * )
 */
class TomeSecurity extends ConfigEntityBase implements TomeSecurityInterface {

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
