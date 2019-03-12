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

use ElseZhang\YiMeiSms\MagicCrypt;
use PHPUnit\Framework\TestCase;

class MagicCryptTest extends TestCase
{
    public function testEmptyStr()
    {
        $originalStr = '';

        $magicCrypt = new MagicCrypt('encrypt-key');
        $encryptStr = $magicCrypt->encrypt($originalStr);

        $this->assertSame($originalStr, $magicCrypt->decrypt($encryptStr));
    }

    public function testNotEmptyStr()
    {
        $originalStr = 'Hello World';

        $magicCrypt = new MagicCrypt('encrypt-key');
        $encryptStr = $magicCrypt->encrypt($originalStr);

        $this->assertSame($originalStr, $magicCrypt->decrypt($encryptStr));
    }
}
