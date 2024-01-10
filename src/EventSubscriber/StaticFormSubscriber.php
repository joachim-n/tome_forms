<?php

namespace Drupal\tome_forms\EventSubscriber;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\tome_static\Event\CollectPathsEvent;
use Drupal\tome_static\Event\ModifyDestinationEvent;
use Drupal\tome_static\Event\TomeStaticEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * TODO: class docs.
 */
class StaticFormSubscriber implements EventSubscriberInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Creates a StaticFormSubscriber instance.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(
    EntityTypeManagerInterface $entity_type_manager
  ) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Reacts to a collect paths event.
   *
   * Adds any paths from tome form entities to the Tome exported paths.
   *
   * @param \Drupal\tome_static\Event\CollectPathsEvent $event
   *   The collect paths event.
   */
  public function collectPaths(CollectPathsEvent $event) {
    $tome_form_storage = $this->entityTypeManager->getStorage('tome_form');
    $tome_form_entities = $tome_form_storage->loadMultiple();
    /** @var \Drupal\tome_forms\Entity\TomeFormInterface */
    foreach ($tome_form_entities as $tome_form_entity) {
      foreach ($tome_form_entity->getPaths() as $path) {
        $event->addPath($path);
      }
    }
  }

  /**
   * Reacts to a modify destination event.
   *
   * @param \Drupal\tome_static\Event\ModifyDestinationEvent $event
   *   The event.
   */
  public function modifyDestination(ModifyDestinationEvent $event) {
    // $destination = $event->getDestination();

    // if ($destination == static::PATH) {
    //   $event->setDestination('static_contact_form_action.php');
    // }
  }


  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[TomeStaticEvents::COLLECT_PATHS][] = ['collectPaths'];
    $events[TomeStaticEvents::MODIFY_DESTINATION][] = ['modifyDestination'];
    return $events;
  }

}
