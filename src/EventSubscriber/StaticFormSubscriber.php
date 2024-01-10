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
   * @param \Drupal\tome_static\Event\CollectPathsEvent $event
   *   The collect paths event.
   */
  public function collectPaths(CollectPathsEvent $event) {
    // $event->addPath(static::PATH);
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
  }

}
