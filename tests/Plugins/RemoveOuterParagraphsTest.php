<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Plugins\RemoveOuterParagraphs;

uses(Tests\TestCase::class);

it('removes outer paragraphs', function () {
    Mutator::plugin(RemoveOuterParagraphs::class);
    $value = $this->getTestValue([[
        'type' => 'paragraph',
        'content' => [[
            'type' => 'image',
            'attrs' => [
                'src' => 'example.jpg',
            ],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<img src="example.jpg">');
});

it('only removes outer paragraphs', function () {
    Mutator::plugin(RemoveOuterParagraphs::class);
    $value = $this->getTestValue([[
        'type' => 'heading',
        'attrs' => [
            'level' => 1,
        ],
        'content' => [[
            'type' => 'image',
            'attrs' => [
                'src' => 'example.jpg',
            ],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<h1><img src="example.jpg"></h1>');
});

it('only removes outer paragraphs when there are no other siblings', function () {
    Mutator::plugin(RemoveOuterParagraphs::class);
    $value = $this->getTestValue([[
        'type' => 'paragraph',
        'content' => [[
            'type' => 'image',
            'attrs' => [
                'src' => 'example.jpg',
            ],
        ], [
            'type' => 'image',
            'attrs' => [
                'src' => 'example.jpg',
            ],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<p><img src="example.jpg"><img src="example.jpg"></p>');
});

it('removes outer paragraphs from configured types', function () {
    Mutator::plugin(RemoveOuterParagraphs::class)
        ->options([
            'types' => ['table'],
        ]);
    $value = $this->getTestValue([[
        'type' => 'paragraph',
        'content' => [[
            'type' => 'image',
            'attrs' => [
                'src' => 'example.jpg',
            ],
        ]],
    ], [
        'type' => 'paragraph',
        'content' => [[
            'type' => 'table',
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<p><img src="example.jpg"></p><table><tbody></tbody></table>');
});
