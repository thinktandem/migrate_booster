<?php

use Drupal\migrate_booster\MigrateBooster;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\ConsoleEvents;

/** @noinspection PhpUnusedParameterInspection */
$GLOBALS['dispatcher']->addListener(ConsoleEvents::COMMAND, function (ConsoleCommandEvent $event) {
  MigrateBooster::bootDrupal();
});
