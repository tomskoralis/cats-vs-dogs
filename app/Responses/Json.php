<?php

namespace App\Responses;

class Json
{
    private string $json;
    private int $code;

    public function __construct(
        string $json,
        int    $code = 200
    )
    {
        $this->json = $json;
        $this->code = $code;
    }

    public function getJson(): string
    {
        return $this->json;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}