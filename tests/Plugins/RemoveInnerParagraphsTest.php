<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Plugins\RemoveInnerParagraphs;

uses(Tests\TestCase::class);

it('removes inner paragraphs', function () {
    Mutator::plugin(RemoveInnerParagraphs::class);
    $value = $this->getTestValue([[
        'type' => 'listItem',
        'content' => [[
            'type' => 'paragraph',
            'content' => [[
                'type' => 'text',
                'text' => 'Test',
            ]],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<li>Test</li>');
});

it('only removes inner paragraphs', function () {
    Mutator::plugin(RemoveInnerParagraphs::class);
    $value = $this->getTestValue([[
        'type' => 'listItem',
        'content' => [[
            'type' => 'heading',
            'attrs' => [
                'level' => 1,
            ],
            'content' => [[
                'type' => 'text',
                'text' => 'Test',
            ]],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<li><h1>Test</h1></li>');
});

it('only removes inner paragraphs when there are no other siblings', function () {
    Mutator::plugin(RemoveInnerParagraphs::class);
    $value = $this->getTestValue([[
        'type' => 'listItem',
        'content' => [[
            'type' => 'paragraph',
            'content' => [[
                'type' => 'text',
                'text' => 'Test',
            ]],
        ], [
            'type' => 'paragraph',
            'content' => [[
                'type' => 'text',
                'text' => 'Test',
            ]],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<li><p>Test</p><p>Test</p></li>');
});

it('removes inner paragraphs from configured types', function () {
    Mutator::plugin(RemoveInnerParagraphs::class)
        ->options([
            'types' => ['tableCell'],
        ]);
    $value = $this->getTestValue([[
        'type' => 'listItem',
        'content' => [[
            'type' => 'paragraph',
            'content' => [[
                'type' => 'text',
                'text' => 'Test',
            ]],
        ]],
    ], [
        'type' => 'tableCell',
        'content' => [[
            'type' => 'paragraph',
            'content' => [[
                'type' => 'text',
                'text' => 'Test',
            ]],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<li><p>Test</p></li><td>Test</td>');
});
