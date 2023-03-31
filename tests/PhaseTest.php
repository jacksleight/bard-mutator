<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

uses(Tests\TestCase::class);

it('calls mutator once per node', function () {
    $calls = 0;
    Mutator::html('paragraph', function ($value) use (&$calls) {
        $calls++;

        return $value;
    });

    $value = $this->getTestValue([[
        'type' => 'paragraph',
    ]]);
    $this->assertEquals('<p></p>', $this->renderTestValue($value));
    $this->assertEquals(1, $calls);
});

it('calls mutator once per mark', function () {
    $calls = 0;
    Mutator::html('bold', function ($value) use (&$calls) {
        $calls++;

        return $value;
    });

    $value = $this->getTestValue([[
        'type' => 'text',
        'text' => 'Some text',
        'marks' => [
            [
                'type' => 'bold',
            ],
        ],
    ]]);
    $this->assertEquals('<strong>Some text</strong>', $this->renderTestValue($value));
    $this->assertEquals(1, $calls);
});

it('calls mutator once per adjacent marks', function () {
    $calls = 0;
    Mutator::html('bold', function ($value) use (&$calls) {
        $calls++;

        return $value;
    });

    $value = $this->getTestValue([
        [
            'type' => 'text',
            'text' => 'Some text',
            'marks' => [
                [
                    'type' => 'bold',
                ],
            ],
        ],
        [
            'type' => 'text',
            'text' => ' and some more text',
            'marks' => [
                [
                    'type' => 'bold',
                ],
            ],
        ],
    ]);
    $this->assertEquals('<strong>Some text and some more text</strong>', $this->renderTestValue($value));
    $this->assertEquals(1, $calls);
});

it('fetches adjacent marks mutated value', function () {
    Mutator::html('link', function ($value) {
        $value[0] = 'fancy-link';

        return $value;
    });

    $value = $this->getTestValue([
        [
            'type' => 'text',
            'text' => 'Some text',
            'marks' => [
                [
                    'type' => 'link',
                    'attrs' => [
                        'href' => 'http://example.com/',
                    ],
                ],
            ],
        ],
        [
            'type' => 'text',
            'text' => ' and some more text',
            'marks' => [
                [
                    'type' => 'link',
                    'attrs' => [
                        'href' => 'http://example.com/',
                    ],
                ],
            ],
        ],
    ]);
    $this->assertEquals('<fancy-link href="http://example.com/">Some text and some more text</fancy-link>', $this->renderTestValue($value));
});
