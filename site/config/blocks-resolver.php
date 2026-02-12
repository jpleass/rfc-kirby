<?php

require_once __DIR__ . '/../plugins/rfc/helpers/data.php';


use Kirby\Cms\Block;
use Kirby\Content\Field;


function resolveButton($button)
{
    $isPage = $button->link()->toPage();
    return [
        'id' => $button->id(),
        'text' => $button->text()->value(),
        'link' => $isPage ? $isPage->uri() : $button->link()->toUrl(),
        'type' => $button->type()->value(),
    ];
}


return [
    // Custom resolves for `block:field`
    'defaultResolvers' => [
        'files' => fn(\Kirby\Cms\File $image) => imageToKirbyImageData($image),
        'pages' => fn(\Kirby\Cms\Page $page) => [
            'uri' => $page->uri(),
            'title' => $page->title()->value()
        ]
    ],
    'resolvers' => [
        // BUTTONS
        'buttons:buttons' => function (Field $field, Block $block) {
            return $field->toStructure()->map(function ($button) {
                return resolveButton($button);
            })->values();
        },
        // GALLERY
        'gallery:images' => function (Field $field, Block $block) {
            return $field->toFiles()->map(function ($image) {
                return imageToKirbyImageData($image);
            })->values();
        },
        // INLINE IMAGE
        'inline-image:image' => function (Field $field, Block $block) {
            return $field->toFile() ? imageToKirbyImageData($field->toFile()) : null;
        },
        // QUOTE
        'quote:logo' => function (Field $field) {
            return $field->toFile() ? imageToKirbyImageData($field->toFile()) : null;
        },
        'quote:logoLink' => function (Field $field) {
            $isPage = $field->toPage();
            return $isPage ? $isPage->uri() : $field->toUrl();
        },
        // BUTTON
        // 'button:link' => function (Field $field) {
        //     $isPage = $field->toPage();
        //     return $isPage ? $isPage->uri() : $field->toUrl();
        // },

        // VIDEO
        'video:video' => function (Field $field, Block $block) {
            return $field->toFile() ? [
                'url' => $field->toFile()->url(),
                'poster' => $block->image()->toFile() ? imageToKirbyImageData($block->image()->toFile()) : null,

            ] : null;
        },
        // TEXT
        'text:text' => function (Field $field, Block $block) {
            return $field->resolvePermalinks()->value();
        },

        // TESTIMONIAL
        'testimonial:logo' => function (Field $field) {
            return $field->toFile() ? imageToKirbyImageData($field->toFile()) : null;
        },
        'testimonial:cover' => function (Field $field) {
            return $field->toFile() ? imageToKirbyImageData($field->toFile()) : null;
        },

        // PAGE LINKS
        'pageLink:cover' => function (Field $field) {
            return $field->toFile() ? imageToKirbyImageData($field->toFile()) : null;
        },
        'pageLink:page' => function (Field $field) {
            $isPage = $field->toPage();
            return $isPage ? [
                'uri' => $isPage->uri(),
                'title' => $isPage->title()->value()
            ] : null;
        },

    ]
];
