<?php

namespace Drupal\tome_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Provides the Tome Form entity.
 *
 * @ConfigEntityType(
 *   id = "tome_form",
 *   label = @Translation("Tome Form"),
 *   label_collection = @Translation("Tome Forms"),
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
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/tome_form/add",
 *     "canonical" = "/admin/structure/tome_form/{tome_form}",
 *     "collection" = "/admin/structure/tome_form",
 *     "edit-form" = "/admin/structure/tome_form/{tome_form}/edit",
 *     "delete-form" = "/admin/structure/tome_form/{tome_form}/delete",
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

}
