<?php

namespace ElseZhang\YiMeiSms;

class MagicCrypt
{
    /**
     * 加密密钥.
     *
     * @var string
     */
    private $encryptKey;

    /**
     * 是否开启GZIP.
     */
    const EN_GZIP = true;

    /**
     * 加密算法.
     */
    const ENCRYPT_METHOD = 'AES-128-ECB';

    /**
     * MagicCrypt constructor.
     *
     * @param string $encryptKey
     */
    public function __construct(string $encryptKey)
    {
        $this->encryptKey = $encryptKey;
    }

    /**
     * 加密.
     *
     * @param string $encryptStr
     *
     * @return string
     */
    public function encrypt(string $encryptStr)
    {
        $encryptKey = $this->encryptKey;

        if (true == self::EN_GZIP) {
            $encryptStr = gzencode($encryptStr);
        }

        $ivSize = openssl_cipher_iv_length(self::ENCRYPT_METHOD);
        $iv = openssl_random_pseudo_bytes($ivSize);

        $encrypted = openssl_encrypt($encryptStr, self::ENCRYPT_METHOD, $encryptKey, OPENSSL_RAW_DATA, $iv);

        return $encrypted;
    }

    /**
     * 解密.
     *
     * @param string $encryptStr
     *
     * @return string
     */
    public function decrypt(string $encryptStr)
    {
        $encryptKey = $this->encryptKey;

        $ivSize = openssl_cipher_iv_length(self::ENCRYPT_METHOD);
        $iv = substr($encryptStr, 0, $ivSize);
        $data = openssl_decrypt(substr($encryptStr, $ivSize), self::ENCRYPT_METHOD, $encryptKey, OPENSSL_RAW_DATA, $iv);

        if (true == self::EN_GZIP) {
            $encryptedData = gzdecode($data);
        }

        return $encryptedData;
    }
}
