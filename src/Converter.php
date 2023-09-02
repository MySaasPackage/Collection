<?php

declare(strict_types=1);

namespace MySaasPackage;

use DateTimeZone;
use DateTimeImmutable;
use InvalidArgumentException;

class Converter
{
    public function __construct(
        protected readonly object|array $data
    ) {
    }

    public function has(string $key): bool
    {
        if (is_object($this->data)) {
            return property_exists($this->data, $key);
        }

        return array_key_exists($key, $this->data);
    }

    public function getOrNull(string $key): mixed
    {
        if (is_object($this->data) && property_exists($this->data, $key)) {
            return $this->data->{$key};
        }

        if (is_array($this->data) && array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return null;
    }

    public function getOrThrow(string $key): mixed
    {
        if ($this->has($key)) {
            return $this->getOrNull($key);
        }

        throw new InvalidArgumentException(sprintf('Property or Key %s not found', $key));
    }

    public function string(string $key): string
    {
        return strval($this->getOrThrow($key));
    }

    public function stringOrNull(string $key): string|null
    {
        if ($this->has($key)) {
            return $this->string($key);
        }

        return null;
    }

    public function int(string $key): int
    {
        return intval($this->getOrThrow($key));
    }

    public function intOrNull(string $key): int|null
    {
        if ($this->has($key)) {
            return $this->int($key);
        }

        return null;
    }

    public function float(string $key): float
    {
        return floatval($this->getOrThrow($key));
    }

    public function floatOrNull(string $key): float|null
    {
        if ($this->has($key)) {
            return $this->float($key);
        }

        return null;
    }

    public function double(string $key): float
    {
        return doubleval($this->getOrThrow($key));
    }

    public function doubleOrNull(string $key): float|null
    {
        if ($this->has($key)) {
            return $this->double($key);
        }

        return null;
    }

    public function bool(string $key): bool
    {
        return boolval($this->getOrThrow($key));
    }

    public function boolOrNull(string $key): ?bool
    {
        if ($this->has($key)) {
            $this->bool($key);
        }

        return null;
    }

    public function datetime(string $key): DateTimeImmutable
    {
        return new DateTimeImmutable($this->string($key));
    }

    public function datetimeOrNull(string $key): DateTimeImmutable|null
    {
        if ($this->has($key)) {
            return $this->datetime($key);
        }

        return null;
    }

    public function timezone(string $key): DateTimeZone
    {
        return new DateTimeZone($this->string($key));
    }

    public function timezoneOrNull(string $key): DateTimeZone|null
    {
        if ($this->has($key)) {
            return $this->timezone($key);
        }

        return null;
    }

    public function converter(string $key): Converter
    {
        return new Converter($this->getOrThrow($key));
    }

    public function converterOrNull(string $key): Converter|null
    {
        if ($this->has($key)) {
            return $this->converter($key);
        }

        return null;
    }

    public function uuid(string $key): Uuid
    {
        return new Uuid($this->string($key));
    }

    public function uuidOrNull(string $key): Uuid|null
    {
        if ($this->has($key)) {
            return $this->uuid($key);
        }

        return null;
    }

    public function email(string $key): Email
    {
        return new Email($this->string($key));
    }

    public function emailOrNull(string $key): Email|null
    {
        if ($this->has($key)) {
            return $this->email($key);
        }

        return null;
    }

    public function phone(string $key): Phone
    {
        return new Phone($this->string($key));
    }

    public function phoneOrNull(string $key): Phone|null
    {
        if ($this->has($key)) {
            return $this->phone($key);
        }

        return null;
    }

    public function password(string $key): Password
    {
        return new Password($this->string($key));
    }

    public function passwordOrNull(string $key): Password|null
    {
        if ($this->has($key)) {
            return $this->password($key);
        }

        return null;
    }

    public function passwordHash(string $key): PasswordHash
    {
        return new PasswordHash($this->string($key));
    }

    public function passwordHashOrNull(string $key): PasswordHash|null
    {
        if ($this->has($key)) {
            return $this->passwordHash($key);
        }

        return null;
    }
}
