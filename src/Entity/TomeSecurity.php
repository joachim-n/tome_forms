<?php

namespace Drupal\tome_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

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
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/tome_security/add",
 *     "canonical" = "/admin/structure/tome_security/{tome_security}",
 *     "collection" = "/admin/structure/tome_security",
 *     "edit-form" = "/admin/structure/tome_security/{tome_security}/edit",
 *     "delete-form" = "/admin/structure/tome_security/{tome_security}/delete",
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

}
