Copied from https://www.drupal.org/sandbox/onkeltem/2828817 and added the patch from https://www.drupal.org/project/2828817/issues/2919993

# About

On Drupal 7 we could disable hooks while running migrations:

    https://www.drupal.org/node/2136601

This module adds a similar feature. You can disable hooks 
in settings.php or by editing configuratoin object `migrate_booster.settings`.

There are two ways to disable hooks: 

1) Disable specific hooks and modules: 

```
$config['migrate_booster.settings']['hooks'] = [
  # Entity insert
  'entity_insert' => [
    'workbench_moderation',
    'pathauto',
    'xmlsitemap',
  ],
  # Entity presave
  'entity_presave' => [
    'xmlsitemap',
  ],
  # Entity predelete
  'entity_predelete' => [
    'flag',
  ],
];
```

2) Disable all hooks of specific modules:

```
$config['migrate_booster.settings']['modules'] = [
  'workbench_moderation',
  'pathauto',
  'xmlsitemap',
];
```
