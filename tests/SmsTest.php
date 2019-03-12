<?php

/*
 * This file is part of the elsezhang/yimei-sms.
 *
 * (c) overtrue <mzhang173@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ElseZhang\YiMeiSms\Tests;

use ElseZhang\YiMeiSms\Sms;
use PHPUnit\Framework\TestCase;

class SmsTest extends TestCase
{
    public function testSend()
    {
    }

    public function testHttpRequest()
    {
    }

    public function testGetMillisecond()
    {
        $sms = new Sms('app-id', 'encrypt-key');
        $millisecond = $sms->getMillisecond();

        $this->assertEquals(13, strlen($millisecond));
        $this->assertFalse(strpos('.', $millisecond));
    }
}
