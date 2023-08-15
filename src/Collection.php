<?php

declare(strict_types=1);

namespace MySaasPackage;

use Countable;
use InvalidArgumentException;

class Collection implements Countable, Arrayable
{
    public function __construct(
        protected array $items = [],
        protected readonly string|null $type = null
    ) {
    }

    protected function guardType($item): void
    {
        if (is_null($this->type)) {
            return;
        }

        if (is_a($item, $this->type, true)) {
            return;
        }

        throw new InvalidArgumentException(sprintf('Item must be of type %s', $this->type));
    }

    public function get(int $index): mixed
    {
        return $this->items[$index] ?? null;
    }

    public function set(int $index, mixed $item): self
    {
        $this->guardType($item);
        $this->items[$index] = $item;

        return $this;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function add(mixed $item): self
    {
        $this->guardType($item);
        $this->items[] = $item;

        return $this;
    }

    public function remove(mixed $item): self
    {
        $this->guardType($item);
        $key = array_search($item, $this->items, true);

        if (false === $key) {
            return $this;
        }

        unset($this->items[$key]);

        return $this;
    }

    public function contains(mixed $item): bool
    {
        $this->guardType($item);

        return in_array($item, $this->items, true);
    }

    public function first(): mixed
    {
        return reset($this->items);
    }

    public function last(): mixed
    {
        return end($this->items);
    }

    public function isEmpty(): bool
    {
        return [] === $this->items;
    }

    public function clear(): self
    {
        $this->items = [];

        return $this;
    }

    public function isGreaterThan(int $count): bool
    {
        return $this->count() > $count;
    }

    public function isLessThan(int $count): bool
    {
        return $this->count() < $count;
    }

    public function isGreaterThanOrEqualTo(int $count): bool
    {
        return $this->count() >= $count;
    }

    public function isLessThanOrEqualTo(int $count): bool
    {
        return $this->count() <= $count;
    }

    public function map(callable $callback): self
    {
        return new self(array_map($callback, $this->items));
    }

    public function filter(callable $callback): self
    {
        return new self(array_filter($this->items, $callback));
    }

    public function merge(self $collection): self
    {
        return new self(array_merge($this->items, $collection->toArray()));
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function __toArray(): array
    {
        return $this->items;
    }
}
