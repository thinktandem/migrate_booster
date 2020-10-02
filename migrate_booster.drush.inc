<?php

use Drupal\migrate_booster\MigrateBooster;

/**
 * Implements hook_drush_init().
 */
function migrate_booster_drush_init() {
  // Skip when bootstrap level is low (e.g. drush cr)
  if (!\Drupal::hasContainer()) {
    return;
  }
  MigrateBooster::bootDrush();
}

/**
 * Implements hook_drush_command().
 */
function migrate_booster_drush_command() {
  $items['migrate-booster-reset'] = [
    'description' => 'Resets migrate booster and implementation cache.',
    'aliases' => ['mbr'],
    'drupal dependencies' => ['migrate_booster'],
  ];
  return $items;
}

function drush_migrate_booster_reset() {
  MigrateBooster::disable();
}
