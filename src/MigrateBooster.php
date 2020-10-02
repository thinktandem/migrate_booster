<?php

namespace Drupal\migrate_booster;

use Consolidation\AnnotatedCommand\AnnotationData;
use Symfony\Component\Console\Input\InputInterface;

class MigrateBooster {

  protected static $alterActive;
  protected static $config;
  const CID = 'migrate_booster_enabled';

  // Startup hooks

  /**
   * Reacts on HOOK_drush_init().
   *
   * Enables/disables booster depending on a drush command invoked.
   *
   */
  public static function bootDrush(InputInterface $input, AnnotationData $annotationData) {
    if (in_array($annotationData['command'], static::getConfig('commands'))) {
      static::enable();
    }
    else {
      static::disable();
    }
  }

  /**
   * Disables booster on Drupal and Drupal console boots.
   */
  public static function bootDrupal() {
    static::disable();
  }

  /**
   * Enables booster.
   *
   * Resets implementation cache and sets $alterActive class variable.
   *
   */
  public static function enable() {
    static::$alterActive = TRUE;
    static::reset();
  }

  /**
   * Disables booster.
   *
   * Resets implementation cache.
   */
  public static function disable() {
    static::reset();
  }

  /**
   * Resets implementations cache.
   */
  public static function reset() {
    $module_handler = \Drupal::moduleHandler();
    $module_handler->resetImplementations();
  }

  /** @noinspection PhpInconsistentReturnPointsInspection */

  /**
   * Implements hook_module_implementation_alter().
   *
   * Disables configured hooks.
   * @param $implementations
   * @param $hook
   * @return null
   */
  public static function alter(&$implementations, $hook) {
    if (!static::$alterActive) {
      return NULL;
    }
    if (!$implementations) {
      return NULL;
    }
    $hooks = static::getConfig('hooks');
    $modules = static::getConfig('modules');
    $disabled = [];
    // Disable by hook + module
    if (in_array($hook, array_keys($hooks))) {
      $disabled = array_intersect_key($implementations, array_flip($hooks[$hook]));
    }
    // Disable by module
    $disabled += array_intersect_key($implementations, array_flip($modules));
    $implementations = array_diff_key($implementations, $disabled);
    /** @noinspection PhpUnusedParameterInspection */
    array_walk($disabled, function ($el, $key) use ($hook) {
      error_log('DISABLED: ' . $key . '_' . $hook);
    });
  }

  // Helper functions

  protected static function getConfig($key) {
    if (!static::$config) {
      static::$config = \Drupal::config('migrate_booster.settings')->get();
    }
    if ($key && isset(static::$config[$key])) {
      return static::$config[$key];
    }
    else {
      return [];
    }
  }

}
