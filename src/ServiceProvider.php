<?php

namespace JackSleight\StatamicBardMutator;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $scripts = [
        __DIR__.'/../dist/js/addon.js',
    ];

    protected $tags = [
        Tags\MutatorTag::class,
    ];

    public function register()
    {
        parent::register();

        $this->app->singleton(Mutator::class, function () {
            return new Mutator([
                'blockquote'      => [\ProseMirrorToHtml\Nodes\Blockquote::class, Nodes\Blockquote::class],
                'bold'            => [\ProseMirrorToHtml\Marks\Bold::class, Marks\Bold::class],
                'bullet_list'     => [\ProseMirrorToHtml\Nodes\BulletList::class, Nodes\BulletList::class],
                'code_block'      => [\ProseMirrorToHtml\Nodes\CodeBlock::class, Nodes\CodeBlock::class],
                'code'            => [\ProseMirrorToHtml\Marks\Code::class, Marks\Code::class],
                'hard_break'      => [\ProseMirrorToHtml\Nodes\HardBreak::class, Nodes\HardBreak::class],
                'heading'         => [\ProseMirrorToHtml\Nodes\Heading::class, Nodes\Heading::class],
                'horizontal_rule' => [\ProseMirrorToHtml\Nodes\HorizontalRule::class, Nodes\HorizontalRule::class],
                'image'           => [\Statamic\Fieldtypes\Bard\ImageNode::class, Nodes\Image::class],
                'italic'          => [\ProseMirrorToHtml\Marks\Italic::class, Marks\Italic::class],
                'link'            => [\Statamic\Fieldtypes\Bard\LinkMark::class, Marks\Link::class],
                'list_item'       => [\ProseMirrorToHtml\Nodes\ListItem::class, Nodes\ListItem::class],
                'ordered_list'    => [\ProseMirrorToHtml\Nodes\OrderedList::class, Nodes\OrderedList::class],
                'paragraph'       => [\ProseMirrorToHtml\Nodes\Paragraph::class, Nodes\Paragraph::class],
                'small'           => [\Statamic\Fieldtypes\Bard\Marks\Small::class, Marks\Small::class],
                'strike'          => [\ProseMirrorToHtml\Marks\Strike::class, Marks\Strike::class],
                'subscript'       => [\ProseMirrorToHtml\Marks\Subscript::class, Marks\Subscript::class],
                'superscript'     => [\ProseMirrorToHtml\Marks\Superscript::class, Marks\Superscript::class],
                'table_cell'      => [\ProseMirrorToHtml\Nodes\TableCell::class, Nodes\TableCell::class],
                'table_header'    => [\ProseMirrorToHtml\Nodes\TableHeader::class, Nodes\TableHeader::class],
                'table_row'       => [\ProseMirrorToHtml\Nodes\TableRow::class, Nodes\TableRow::class],
                'table'           => [\ProseMirrorToHtml\Nodes\Table::class, Nodes\Table::class],
                'underline'       => [\ProseMirrorToHtml\Marks\Underline::class, Marks\Underline::class],
            ]);
        });
    }
}
