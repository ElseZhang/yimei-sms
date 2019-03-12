<?php

/*
 * This file is part of the elsezhang/yimei-sms.
 *
 * (c) overtrue <mzhang173@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ElseZhang\YiMeiSms;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Sms::class, function () {
            return new Sms(config('services.yimei_sms.app_id'), config('services.yimei_sms.encrypt_key'));
        });

        $this->app->alias(Sms::class, 'sms');
    }

    public function provides()
    {
        return [Sms::class, 'sms'];
    }
}
