<?php

use Kirby\Cms\App as Kirby;

require_once __DIR__ . '/helpers/data.php';



Kirby::plugin('joseph-pleass/rfc', [
  /**
   * @kql-allowed
   */
  'tags' => [
    'caption' => [
      'html' => fn($tag) => '<span class="caption-text small body-text">' . $tag->value . '</span>'
    ]
  ],
  'fieldMethods' => [
    /**
     * @kql-allowed
     */
    'toButtons' => function ($field) {
      $buttons = $field->toStructure();
      return $buttons->map(function ($button) {
        return resolveButton($button);
      })->values();
    }
  ],
  'pageMethods' => [],
  'pagesMethods' => [],
  'siteMethods' => []
]);
