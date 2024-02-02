<?php

namespace PayPro;

final class PayProTest extends TestCase
{
    public function testGetVersion()
    {
        $this->assertSame(PayPro::getVersion(), '0.1.0');
    }
}
