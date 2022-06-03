<!-- statamic:hide -->

![Statamic](https://flat.badgen.net/badge/Statamic/3.1.14+/FF269E)
![Packagist version](https://flat.badgen.net/packagist/v/jacksleight/statamic-bard-mutator)
![License](https://flat.badgen.net/github/license/jacksleight/statamic-bard-mutator)

# Bard Mutator 

<!-- /statamic:hide -->

This Statamic addon allows you to modify the data and tags rendered by the Bard fieldtype, giving you full control over the final HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely. You can also make changes the raw data before anything is rendered to HTML.

## Examples

Here are a few examples of what's possible. For more information and more examples check [the documentation](https://jacksleight.github.io/statamic-bard-mutator/).

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

### Remove paragraph nodes inside list items

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::data('listItem', function ($data) {
    if (($data->content[0]->type ?? null) === 'paragraph') {
        $data->content = $data->content[0]->content;
    }
});
```

## Documentation

[Statamic Bard Mutator Documentation](https://jacksleight.github.io/statamic-bard-mutator/)

## Compatibility

In order to give you access to the TipTap rendering process Bard Mutator has to replace the built-in extensions with its own. It can only do that reliably if there are no other addons (or user code) trying to do the same thing. To help minimise incompatibilities Bard Mutator will only replace the extensions that are actually being mutated, everyting else is left alone.

*However*, if you have other addons (or user code) that replace any of the extensions that Bard Mutator is also replacing it probably won't work properly. Unfortunately I don’t think there’s a way around that. This does not affect custom nodes and marks.