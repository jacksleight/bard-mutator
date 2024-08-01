---
title: Upgrade 2.0 to 3.0
order: 110
---

# Upgrade from 2.0 to 3.0

[TOC]

---

## Terminology Change

Mutators--the individual chunks of code that do something--are now called Plugins. The documentation and the rest of this upgrade guide uses this new terminology.

## Breaking Changes

### Editor class binding removed (High Impact)

It is no longer necessary to bind a custom Tiptap Editor class in order to use advanced features, and Bard Mutator's Editor class has been removed. If you enabled this you should remove it from your app service providers `register()` method:

```diff
-$this->app->bind(
-    \Tiptap\Editor::class,
-    \JackSleight\StatamicBardMutator\Editor::class
-);
```

### Deprecated methods removed (Low Impact)

## Deprecated

### Individual render/parse HTML methods

The individual `Mutator::renderHtml()` and `Mutator::parseHtml()` methods have been deprecated. These were never documentented so it's unlinkely anyone is using them, and they were just aliases for `Mutator::html()` anyway.

### Reverse HTML mutators

Reverse HTML mutators have been deprecated and will be removed in a future version. They never really made sense as part of Mutator, they can’t currently work with the new field specific plugin configuration, and as far as I’m aware no one’s using using them anyway.