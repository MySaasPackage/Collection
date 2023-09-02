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
        if (is_object($this->data) && property_exists($this->data, $key)) {
            return true;
        }

        if (is_array($this->data) && array_key_exists($key, $this->data)) {
            return true;
        }

        return false;
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
        return $this->getOrThrow($key);
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
        $doubleOrNull = $this->getOrNull($key);

        if (null === $doubleOrNull) {
            return null;
        }

        return doubleval($doubleOrNull);
    }

    public function bool(string $key): bool
    {
        return boolval($this->getOrThrow($key));
    }

    public function boolOrNull(string $key): ?bool
    {
        $boolOrNull = $this->getOrNull($key);

        if (null === $boolOrNull) {
            return null;
        }

        return boolval($boolOrNull);
    }

    public function datetime(string $key): DateTimeImmutable
    {
        return new DateTimeImmutable($this->getOrThrow($key));
    }

    public function datetimeOrNull(string $key): DateTimeImmutable|null
    {
        $datetimeOrNull = $this->getOrNull($key);

        if (null === $datetimeOrNull) {
            return null;
        }

        return new DateTimeImmutable($datetimeOrNull);
    }

    public function timezone(string $key): DateTimeZone
    {
        return new DateTimeZone($this->getOrThrow($key));
    }

    public function timezoneOrNull(string $key): DateTimeZone|null
    {
        $timezoneOrNull = $this->getOrNull($key);

        if (null === $timezoneOrNull) {
            return null;
        }

        return new DateTimeZone($timezoneOrNull);
    }

    public function converter(string $key): Converter
    {
        return new Converter($this->getOrThrow($key));
    }

    public function converterOrNull(string $key): Converter|null
    {
        $childrenOrNull = $this->getOrNull($key);

        if (null === $childrenOrNull) {
            return null;
        }

        return new Converter($childrenOrNull);
    }

    public function uuid(string $key): Uuid
    {
        return new Uuid($this->getOrThrow($key));
    }

    public function uuidOrNull(string $key): Uuid|null
    {
        $uuidOrNull = $this->getOrNull($key);

        if (null === $uuidOrNull) {
            return null;
        }

        return new Uuid($uuidOrNull);
    }

    public function email(string $key): Email
    {
        return new Email($this->getOrThrow($key));
    }

    public function emailOrNull(string $key): Email|null
    {
        $emailOrNull = $this->getOrNull($key);

        if (null === $emailOrNull) {
            return null;
        }

        return new Email($emailOrNull);
    }

    public function phone(string $key): Phone
    {
        return new Phone($this->getOrThrow($key));
    }

    public function phoneOrNull(string $key): Phone|null
    {
        $phoneOrNull = $this->getOrNull($key);

        if (null === $phoneOrNull) {
            return null;
        }

        return new Phone($phoneOrNull);
    }

    public function password(string $key): Password
    {
        return new Password($this->getOrThrow($key));
    }

    public function passwordOrNull(string $key): Password|null
    {
        $passwordOrNull = $this->getOrNull($key);

        if (null === $passwordOrNull) {
            return null;
        }

        return new Password($passwordOrNull);
    }

    public function passwordHash(string $key): PasswordHash
    {
        return new PasswordHash($this->getOrThrow($key));
    }

    public function passwordHashOrNull(string $key): PasswordHash|null
    {
        $passwordHashOrNull = $this->getOrNull($key);

        if (null === $passwordHashOrNull) {
            return null;
        }

        return new PasswordHash($passwordHashOrNull);
    }
}
