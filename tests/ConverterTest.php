<?php

declare(strict_types=1);

namespace MySaasPackage;

use stdClass;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    public function testConverterSuccess()
    {
        $converter = new Converter([
            'uuid' => '00000000-0000-0000-0000-000000000000',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'alef@gmail.com',
            'phone' => '+5511999999999',
            'createdAt' => '2020-01-01 00:00:00',
        ]);

        $this->assertEquals('John', $converter->string('firstName'));
        $this->assertEquals('Doe', $converter->string('lastName'));
        $this->assertEquals(new Uuid('00000000-0000-0000-0000-000000000000'), $converter->uuid('uuid'));
        $this->assertEquals(new Email('alef@gmail.com'), $converter->email('email'));
        $this->assertEquals(new Phone('+5511999999999'), $converter->phone('phone'));
        $this->assertEquals(new DateTimeImmutable('2020-01-01 00:00:00'), $converter->datetime('createdAt'));
    }

    public function testConverterWithNullValues()
    {
        $converter = new Converter([
            'uuid' => null,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => null,
            'phone' => null,
            'createdAt' => null,
        ]);

        $this->assertEquals('John', $converter->string('firstName'));
        $this->assertEquals('Doe', $converter->string('lastName'));
        $this->assertEquals(null, $converter->uuidOrNull('uuid'));
        $this->assertEquals(null, $converter->emailOrNull('email'));
        $this->assertEquals(null, $converter->phoneOrNull('phone'));
        $this->assertEquals(null, $converter->datetimeOrNull('createdAt'));
    }

    public function testConverterObjectSuccess()
    {
        $object = new stdClass();
        $object->uuid = '00000000-0000-0000-0000-000000000000';
        $object->firstName = 'John';
        $object->lastName = 'Doe';
        $object->email = 'alef@gmail.com';
        $object->phone = '+5511999999999';
        $object->createdAt = '2020-01-01 00:00:00';

        $converter = new Converter($object);

        $this->assertEquals('John', $converter->string('firstName'));
        $this->assertEquals('Doe', $converter->string('lastName'));
        $this->assertEquals(new Uuid('00000000-0000-0000-0000-000000000000'), $converter->uuid('uuid'));
        $this->assertEquals(new Email('alef@gmail.com'), $converter->email('email'));
        $this->assertEquals(new Phone('+5511999999999'), $converter->phone('phone'));
        $this->assertEquals(new DateTimeImmutable('2020-01-01 00:00:00'), $converter->datetime('createdAt'));
    }

    public function testConverterObjectWithNullValues()
    {
        $object = new stdClass();
        $object->uuid = null;
        $object->firstName = 'John';
        $object->lastName = 'Doe';
        $object->email = null;
        $object->phone = null;
        $object->createdAt = null;

        $converter = new Converter($object);
        $this->assertEquals('John', $converter->string('firstName'));
        $this->assertEquals('Doe', $converter->string('lastName'));
        $this->assertEquals(null, $converter->uuidOrNull('uuid'));
        $this->assertEquals(null, $converter->emailOrNull('email'));
        $this->assertEquals(null, $converter->phoneOrNull('phone'));
        $this->assertEquals(null, $converter->datetimeOrNull('createdAt'));
    }
}
