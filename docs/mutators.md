---
title: Mutators
order: 3
---

# Mutators

[TOC]

---

## HTML Mutators

HTML mutators allow you to modify the [HTML values](data-formats#html-values) that Tiptap converts to HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely. Here's an example that adds a class attribute to all lists, there are more on the [examples](examples) page.

```php
# app/Providers/AppServiceProvider.php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html(['bulletList', 'orderedList'], function ($value) {
    $value[1]['class'] = 'list';
    return $value;
});
```

You should add render HTML mutators in a service provider's `boot()` method. They can receive any of the following arguments which you can specify in any order:

* **value (array):** The standard [HTML value](data-formats)
* **data (object):** The raw [node and mark data](data-formats)
* **meta (array):** Metadata about the current node or mark (see below)
* **type (string):** The type of the current node or mark
* **HTMLAttributes (array):** Tiptap's internal array of HTML attributes

You should return an [HTML value](data-formats). If you return `null` or an empty array no tags will be rendered but the content will be. You can add multiple tag mutators for the same type, they'll be executed in the order they were added.

### Reverse Mutators

The `Mutator::html()` method also accepts a second closure where you can specify how existing HTML should be converted back to the original value. This is only necessary if you're using Bard's `save_html` option.

```php
# app/Providers/AppServiceProvider.php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('image', function ($value) {
    $value[0] = 'fancy-image';
    return $value;
}, function ($value) {
    return array_merge($value, [
        ['tag' => 'fancy-image'],
    ]);
});
```

---

## Data Mutators

:::important
This is an advanced feature that requires an [additonal step](installation#enabling-advanced-features) to enable.
:::

Data mutators allow you to make changes to the raw [node and mark data](data-formats) before anything is rendered to HTML. Here's an example that removes the paragraph nodes inside list items.

```php
# app/Providers/AppServiceProvider.php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::data('list_item', function ($value) {
    if (($value->content[0]->type ?? null) === 'paragraph') {
        $value->content = $value->content[0]->content;
    }
});
```

You should add data mutators in a service provider's `boot()` method. They can receive any of the following arguments which you can specify in any order:

* **value (object):** The raw [node and mark data](data-formats)
* **meta (array):** Metadata about the current node or mark (see below)
* **type (string):** The type of the current node or mark

Data mutators do not return a value, you can just modify the objects directly. You can add multiple data mutators for the same type, they'll be executed in the order they were added.

---

## Metadata

:::important
This is an advanced feature that requires an [additonal step](installation#enabling-advanced-features) to enable.
:::

The `$meta` argument contains metadata about the current node or mark. It's an array that contains the following keys:

* **root (object):** The `bmu_root` node for this Bard value
* **parent (object):** The parent node
* **prev (object):** The previous node/mark
* **next (object):** The next node/mark
* **index (int):** The index of the current node/mark
* **depth (int):** The depth of the current node/mark