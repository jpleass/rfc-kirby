<?php

use Kirby\Cms\App as Kirby;

require_once __DIR__ . '/helpers/data.php';
require_once __DIR__ . '/helpers/links.php';
require_once __DIR__ . '/helpers/traverse.php';


Kirby::plugin('joseph-pleass/atria', [
  /**
   * @kql-allowed
   */
  'tags' => [
    'caption' => [
      'html' => fn($tag) => '<span class="caption-text small body-text">' . $tag->value . '</span>'
    ]
  ],
  'fieldMethods' => [],
  'pageMethods' => [],
  'pagesMethods' => [],
  'siteMethods' => []
]);
