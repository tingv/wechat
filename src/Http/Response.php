<?php

namespace WeWork\Http;

use Psr\Http\Message\StreamInterface;

class Response extends \GuzzleHttp\Psr7\Response
{
    /**
     * @inheritdoc
     */
    public function getBody(): StreamInterface
    {
        $stream = parent::getBody();

        $data = json_decode((string)$stream, true);

        if (JSON_ERROR_NONE === json_last_error() && $data['errcode'] !== 0) {
            throw new \InvalidArgumentException($data['errmsg'], $data['errcode']);
        }

        return $stream;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return \GuzzleHttp\Utils::jsonDecode((string)$this->getBody(), true);
    }
}
