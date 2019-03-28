<?php

/*
 * This file is part of the elsezhang/yimei-sms.
 *
 * (c) ElseZhang <mzhang173@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ElseZhang\YiMeiSms;

use ElseZhang\YiMeiSms\Exceptions\Exception;
use ElseZhang\YiMeiSms\Exceptions\HttpException;
use GuzzleHttp\Client;

class Sms
{
    /**
     * APPID.
     *
     * @var string
     */
    private $appId;

    /**
     * 加密密钥.
     *
     * @var string
     */
    private $encryptKey;

    /**
     * 接口地址
     */
    const YM_SMS_ADDR = 'http://bjksmtn.b2m.cn:80';

    /**
     * 发送单条短信接口.
     */
    const YM_SMS_SEND_URI = '/inter/sendSingleSMS';

    /**
     * 发送单条短信接口.
     */
    const END = "\n";

    /**
     * 是否开启GZIP.
     */
    const EN_GZIP = true;

    /**
     * Sms constructor.
     *
     * @param string $appId
     * @param string $encryptKey
     */
    public function __construct(string $appId, string $encryptKey)
    {
        $this->appId = $appId;
        $this->encryptKey = $encryptKey;
    }

    /**
     * 单条短信发送
     *
     * @param string $mobile
     * @param string $content
     * @param string $timerTime
     * @param string $customSmsId
     * @param string $extendedCode
     * @param int    $requestValidPeriod
     *
     * @return bool|string
     *
     * @throws HttpException
     */
    public function send(string $mobile, string $content,
                         string $timerTime = '', string $customSmsId = '',
                         string $extendedCode = '',
                         int $requestValidPeriod = 120)
    {
        $item = new \stdClass();
        $item->mobile = $mobile;
        $item->content = $content;

        /* 选填内容 */
        if ('' != $timerTime) {
            $item->timerTime = $timerTime;
        }
        if ('' != $customSmsId) {
            $item->customSmsId = $customSmsId;
        }
        if ('' != $extendedCode) {
            $item->extendedCode = $extendedCode;
        }

        $item->requestTime = $this->getMillisecond();
        $item->requestValidPeriod = $requestValidPeriod;

        $jsonData = json_encode($item, JSON_UNESCAPED_UNICODE);

        $encryptObj = new MagicCrypt($this->encryptKey);
        $sendData = $encryptObj->encrypt($jsonData); // 加密结果

        try {
            $response = $this->httpRequest(self::YM_SMS_SEND_URI, $sendData);
            $headers = $response->getHeaders();
            if ('SUCCESS' == $headers['result']) {
                $body = $response->getBody();

                return $encryptObj->decrypt($body->getContents());
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * HTTP 请求
     *
     * @param string $url
     * @param null   $data
     *
     * @throws HttpException
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function httpRequest(string $url, $data = null)
    {
        try {
            $client = new Client([
                'base_uri' => self::YM_SMS_ADDR,
                'timeout' => 30,
                'allow_redirects' => false,
            ]);
            $headers = [
                'appId' => $this->appId,
            ];
            if (true == self::EN_GZIP) {
                $headers['gzip'] = 'on';
            }

            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'body' => $data,
            ]);

            return $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 返回当前 Unix 时间戳的毫秒数.
     *
     * @return string
     */
    public function getMillisecond()
    {
        list($microsec, $sec) = explode(' ', microtime());

        return sprintf('%.0f', (floatval($microsec) + floatval($sec)) * 1000);
    }
}
