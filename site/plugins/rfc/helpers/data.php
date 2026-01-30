<?php



/**
 * Converts a Kirby File object to an array of image data.
 *
 * @param \Kirby\Cms\File|null $image
 * @return array<string, mixed>|null
 */
function imageToKirbyImageData(?\Kirby\Cms\File $image): ?array
{
  if (!$image || !$image instanceof \Kirby\Cms\File) {
    return null;
  }

  return [
    'url' => $image->url(),
    'uuid' => $image->uuid()->toString(),
    'id' => $image->id(),
    'src' => $image->resize(1024, 1024, 80)->url(),
    'srcset' => $image->srcset([480, 768, 1024, 1280, 1440, 2048]),
    'caption' => $image->caption()->value(),
    'alt' => $image->alt()->value(),
    'width' => $image->width(),
    'height' => $image->height(),
    'filename' => $image->filename(),
    'mime' => $image->mime(),
    'blurUrl' => $image->resize(4, 4, 80)->url(),
  ];
}
