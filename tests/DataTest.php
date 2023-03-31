<?php

use JackSleight\StatamicBardMutator\Support\Data;

uses(Tests\TestCase::class);

it('creates node object', function () {
    $node = Data::node('paragraph');

    expect($node->type)->toEqual('paragraph');
});

it('creates node object with attributes', function () {
    $node = Data::node('image', ['src' => 'https://example.com/image.jpg']);

    expect($node->type)->toEqual('image');
    expect($node->attrs->src)->toEqual('https://example.com/image.jpg');
});

it('creates mark object', function () {
    $mark = Data::mark('bold');

    expect($mark->type)->toEqual('bold');
});

it('creates mark object with attributes', function () {
    $mark = Data::mark('link', ['href' => 'https://example.com']);

    expect($mark->type)->toEqual('link');
    expect($mark->attrs->href)->toEqual('https://example.com');
});

it('creates text node object', function () {
    $node = Data::text('Hello world');

    expect($node->type)->toEqual('text');
    expect($node->text)->toEqual('Hello world');
});

it('creates html node object', function () {
    $node = Data::html('<p>Hello world</p>');

    expect($node->type)->toEqual('bmuHtml');
    expect($node->html)->toEqual('<p>Hello world</p>');
});
