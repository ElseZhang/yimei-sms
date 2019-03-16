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

use ElseZhang\YiMeiSms\MagicCrypt;
use PHPUnit\Framework\TestCase;

class MagicCryptTest extends TestCase
{
    protected $magicCrypt;

    protected function setUp()
    {
        $this->magicCrypt = new MagicCrypt('encrypt-key');
    }

    public function testEmptyStr()
    {
        $originalStr = '';

        $magicCrypt = $this->magicCrypt;
        $encryptStr = $magicCrypt->encrypt($originalStr);

        $this->assertSame($originalStr, $magicCrypt->decrypt($encryptStr));
    }

    public function testNotEmptyStr()
    {
        $originalStr = 'Hello World';

        $magicCrypt = $this->magicCrypt;
        $encryptStr = $magicCrypt->encrypt($originalStr);

        $this->assertSame($originalStr, $magicCrypt->decrypt($encryptStr));
    }

    protected function tearDown()
    {
        $this->magicCrypt = null;
    }
}
