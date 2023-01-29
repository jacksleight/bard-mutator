<!-- statamic:hide -->

![Statamic](https://flat.badgen.net/badge/Statamic/3.1.14+/FF269E)
![Packagist version](https://flat.badgen.net/packagist/v/jacksleight/statamic-bard-mutator)
![License](https://flat.badgen.net/github/license/jacksleight/statamic-bard-mutator)

# Bard Mutator 

<!-- /statamic:hide -->

This Statamic addon allows you to modify the data and tags rendered by the Bard fieldtype, giving you full control over the final HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely. You can also make changes the raw data before anything is rendered to HTML.

## Examples

Here are a few examples of what's possible. For more information and more examples check [the documentation](https://jacksleight.dev/docs/bard-mutator/examples).

### Add `noopener` to all external links

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Facades\URL;

Mutator::html('link', function ($value) {
    if (URL::isExternal($value[1]['href'])) {
        $value[1]['rel'] = 'noopener';
    }
    return $value;
});
```

### Add an auto-generated ID to all level 2 headings

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('heading', function ($value, $data) {
    if ($data->attrs->level === 2) {
        $value[1]['id'] = str_slug(collect($data->content)->implode('text', ''));
    }
    return $value;
});
```

### Remove paragraph tags inside list items and table cells

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::data('listItem', function ($data) {
    if (($data->content[0]->type ?? null) === 'paragraph') {
        $data->content = $data->content[0]->content;
    }
    return $tag;
});
```

## Documentation

[Statamic Bard Mutator Documentation](https://jacksleight.dev/docs/bard-mutator)

## Compatibility

In order to give you access to the Tiptap rendering process Bard Mutator has to override the Tiptap editor class and replace the built-in extensions with its own. It can only do that reliably if there are no other addons (or user code) trying to do the same thing. To help minimise incompatibilities Bard Mutator will only replace extensions that are actually being mutated.

## Sponsoring 

This addon is completely free to use. However fixing bugs, adding features and helping users takes time and effort. If you find this addon useful and would like to support its development any [contribution](https://github.com/sponsors/jacksleight) would be greatly appreciated. Thanks! 🙂