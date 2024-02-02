<?php

namespace PayPro;

use PayPro\Exception\InvalidArgumentException;
use PayPro\Exception\SignatureVerificationException;

final class SignatureTest extends TestCase
{
    public function testConstructorWithInvalidTimestamp()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('timestamp must be an epoch integer');

        new Signature('test', 'timestmap', 'secret');
    }

    public function testConstructorWithInvalidPayload()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('payload must be a string');

        new Signature(100, 100, 'secret');
    }

    public function testConstructorWithInvalidSecret()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('secret must be a string');

        new Signature('test', 100, 100);
    }

    public function testConstructorWithInvalidTolerance()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('tolerance must be an integer');

        new Signature('test', 100, 'secret', 'test');
    }

    public function testGenerateSignature()
    {
        $signatureObject = new Signature('', 1702298964, 'secret');
        $signature = $signatureObject->generateSignature();

        self::assertSame($signature, '11a78a4daf3d96996a022be567e444b72bf5f7462311529f0342e0f152d32803');

        $signatureObject = new Signature(
            '{"id": "EVYK7KCFJAXA23UKSG"}',
            1672527600,
            '996QF2kLfVcmF8hzikZVfeB7GPH2RdP7'
        );

        $signature = $signatureObject->generateSignature();

        self::assertSame($signature, '9dfc94dfd152e5c428a5b72c27bbbada0c2d81c266b62ab93ab7087aa773729b');
    }

    public function testVerifyWithInvalidSignature()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('signature must be a string');

        $signatureObject = new Signature('', 1702298964, 'secret');
        $signatureObject->verify(1000);
    }

    public function testVerifySignatureDoesNoMatch()
    {
        $this->expectException(SignatureVerificationException::class);
        $this->expectExceptionMessage('Signature does not match');

        $signatureObject = new Signature('', 1702298964, 'secret');
        $signatureObject->verify('signature');
    }

    public function testVerifyTimestampTooOld()
    {
        $this->expectException(SignatureVerificationException::class);
        $this->expectExceptionMessage('Timestamp is outside the tolerance zone');

        $timestamp = time() - 60;

        $signatureObject = new Signature('', $timestamp, 'secret', 30);
        $signature = $signatureObject->generateSignature();

        $signatureObject->verify($signature);
    }

    public function testVerifyTimestampTooNew()
    {
        $this->expectException(SignatureVerificationException::class);
        $this->expectExceptionMessage('Timestamp is outside the tolerance zone');

        $timestamp = time() + 60;

        $signatureObject = new Signature('', $timestamp, 'secret', 30);
        $signature = $signatureObject->generateSignature();

        $signatureObject->verify($signature);
    }

    public function testVerifySignature()
    {
        $signatureObject = new Signature('', 1702298964, 'secret', 100000000000);
        self::assertTrue($signatureObject->verify('11a78a4daf3d96996a022be567e444b72bf5f7462311529f0342e0f152d32803'));
    }
}
