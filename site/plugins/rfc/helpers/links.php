<?php

function getLinkType($link)
{
  // 'url' | 'page' | 'file' | 'email' | 'phone' | 'anchor'
  if ($link->toPage()) {
    return 'page';
  } elseif ($link->toFile()) {
    return 'file';
  } elseif (preg_match('/^https?:\/\//', $link->value())) {
    return 'url';
  } elseif (preg_match('/^mailto:/', $link->value())) {
    return 'email';
  } elseif (preg_match('/^tel:/', $link->value())) {
    return 'phone';
  } elseif (preg_match('/^#/', $link->value())) {
    return 'anchor';
  }
  return 'url';
}

function processLinks($links, ?callable $customMapper = null): array
{
  $processedLinks = [];
  $links = $links->toStructure();

  foreach ($links as $link) {
    $isPage = $link->link()->toPage();
    $baseData = [
      'id' => $link->id(),
      'text' => $isPage && $link->text()->isEmpty() ? $isPage->summary()->value() : $link->text()->value(),
      'link' => $isPage ? $isPage->uri() : $link->link()->toUrl(),
      'type' => getLinkType($link->link()),
    ];

    // Apply custom mapping if provided
    if ($customMapper) {
      $processedLinks[] = $customMapper($link, $isPage, $baseData);
    } else {
      $processedLinks[] = $baseData;
    }
  }

  return $processedLinks;
}
