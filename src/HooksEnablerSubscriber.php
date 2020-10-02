<?php

namespace Drupal\migrate_booster;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Provides a MyModuleSubscriber.
*/
class HooksEnablerSubscriber implements EventSubscriberInterface {

  /**
  * {@inheritdoc}
  */
  static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = array('ensureHooksEnabled', 20);
    return $events;
  }

  /**
   * Triggers on 'kernel.request' event which occurs when Drupal
   * bootstraps (but not when Drush or Drupal console command runs).
   */
  public function ensureHooksEnabled() {
    MigrateBooster::bootDrupal();
  }

}
