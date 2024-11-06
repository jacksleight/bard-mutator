<?php

namespace JackSleight\StatamicBardMutator\Plugins;

class RemoveInnerParagraphs extends Plugin
{
    protected array $options = [
        'types' => ['listItem', 'tableCell'],
    ];

    public function types(): array
    {
        return $this->options['types'];
    }

    public function process(object $item, object $info): void
    {
        $content = $item->content ?? [];

        if (count($content) !== 1) {
            return;
        }

        $inner = $content[0];

        if ($inner->type !== 'paragraph') {
            return;
        }

        $item->content = $inner->content;
    }
}
