<?php

namespace PayPro;

final class PayProTest extends \PayPro\TestCase
{
    public function testGetVersion()
    {
        $this->assertSame(\PayPro\PayPro::getVersion(), '0.1.0');
    }
}
