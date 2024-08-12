<?php

namespace PayPro;

final class PayProTest extends TestCase
{
    public function testGetVersion()
    {
        self::assertSame(PayPro::getVersion(), '1.1.0');
    }
}
