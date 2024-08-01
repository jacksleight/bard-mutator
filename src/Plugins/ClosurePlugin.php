<?php

namespace JackSleight\StatamicBardMutator\Plugins;

use Closure;
use Statamic\Support\Arr;

class ClosurePlugin extends Plugin
{
    protected ?Closure $process;

    protected ?Closure $render;

    protected ?Closure $parse;

    public function handle(string $handle = null): static|string|null
    {
        if (func_num_args()) {
            $this->handle = $handle;

            return $this;
        }

        return $this->handle;
    }

    public function __construct($types, ?Closure $process = null, ?Closure $render = null, ?Closure $parse = null)
    {
        $this->types = Arr::wrap($types);
        $this->process = $process;
        $this->render = $render;
        $this->parse = $parse;
    }

    public function process(object $data, array $meta): void
    {
        if (! $this->process) {
            return;
        }

        app()->call($this->process, [
            'type' => $data->type,
            'meta' => $meta,
            'data' => $data,
        ]);
    }

    public function render(array $value, array $meta, array $params): array
    {
        if (! $this->render) {
            return $value;
        }

        return app()->call($this->render, [
            'type' => $params['data']->type,
            'meta' => $meta,
            'value' => $value,
        ] + $params);
    }

    public function parse(array $value, array $meta, array $params): array
    {
        if (! $this->parse) {
            return $value;
        }

        return app()->call($this->parse, [
            'type' => $params['data']->type,
            'meta' => $meta,
            'value' => $value,
        ] + $params);
    }
}
