<?php

require_once __DIR__ . '/../plugins/atria/helpers/data.php';
require_once __DIR__ . '/../plugins/atria/helpers/links.php';


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
    ]
];
