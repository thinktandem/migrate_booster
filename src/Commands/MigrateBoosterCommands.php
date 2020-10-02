<?php
namespace Drupal\migrate_booster\Commands;

use Consolidation\AnnotatedCommand\AnnotationData;
use Drupal\migrate_booster\MigrateBooster;
use Drush\Commands\DrushCommands;
use Symfony\Component\Console\Input\InputInterface;

/**
 *
 * In addition to a commandfile like this one, you need a drush.services.yml
 * in root of your module.
 *
 * See these files for an example of injecting Drupal services:
 *   - http://cgit.drupalcode.org/devel/tree/src/Commands/DevelCommands.php
 *   - http://cgit.drupalcode.org/devel/tree/drush.services.yml
 */
class MigrateBoosterCommands extends DrushCommands {

  /**
   * Resets migrate booster and implementation cache.
   *
   * @command migrate:booster:reset
   *
   * @validate-module-enabled migrate_booster
   * @aliases mbr,migrate-booster-reset
   */
  public function boosterReset()
  {
      // See bottom of https://weitzman.github.io/blog/port-to-drush9 for details on what to change when porting a
      // legacy command.
    MigrateBooster::reset();
  }

  /**
   * Enables migrate booster and implementation cache.
   *
   * @command migrate:booster:enable
   *
   * @validate-module-enabled migrate_booster
   * @aliases mbe,migrate-booster-enable
   */
  public function boosterEnable()
  {
    // See bottom of https://weitzman.github.io/blog/port-to-drush9 for details on what to change when porting a
    // legacy command.

    MigrateBooster::enable();
  }

  /**
   * @hook init *
   */
  public function initCommand(InputInterface $input, AnnotationData $annotationData) {
    // Skip when bootstrap level is low (e.g. drush cr)
    if (!\Drupal::hasContainer()) {
      return;
    }
    MigrateBooster::bootDrush($input, $annotationData);
  }
}
