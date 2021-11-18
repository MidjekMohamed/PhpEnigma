<?php

declare(strict_types=1);

namespace src\Http;

class Response
{
    public function __construct(
        private string $content,
        private int $status = 200,
        private array $headers=['Content-Type : text/html'])
    {
    }

    public function display():void
    {
        //header status
        $this->sendHeaders();
        echo $this->content;
        //other headers
        //content
    }

    public function sendHeaders(){
        header("HTTP/1.1 $this->status");
        foreach ($this->headers as $header)
        {
            header($header);
        }
    }
}