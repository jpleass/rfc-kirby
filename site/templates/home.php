<?php

/** @var \Kirby\Cms\Page $page */

$data = [
  'title' => $page->title()->value(),
];

echo \Kirby\Data\Json::encode($data);
