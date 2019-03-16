<?php

/*
 * This file is part of the elsezhang/yimei-sms.
 *
 * (c) ElseZhang <mzhang173@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ElseZhang\YiMeiSms\Tests;

use ElseZhang\YiMeiSms\Sms;
use PHPUnit\Framework\TestCase;

class SmsTest extends TestCase
{
    protected $sms;

    protected function setUp()
    {
        $this->sms = new Sms('app-id', 'encrypt-key');
    }

    public function testSend()
    {
    }

    public function testHttpRequest()
    {
    }

    public function testGetMillisecond()
    {
        $millisecond = $this->sms->getMillisecond();

        $this->assertRegExp('/^\d*$/', $millisecond);
        $this->assertEquals(13, strlen($millisecond));
    }

    protected function tearDown()
    {
        $this->sms = null;
    }
}
