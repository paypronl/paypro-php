<?php

namespace PayPro;

final class PayProTest extends TestCase
{
    public function testGetVersion()
    {
        self::assertSame(PayPro::getVersion(), '0.1.0');
    }
}
