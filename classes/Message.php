<?php

class Message {
    public int $ErrorId;
    public string $Message;
    public $data;

    public function __construct(int $id, string $msg, $data = null)
    {
        $this->ErrorId = $id;
        $this->Message = $msg;
        $this->data = $data;
    }
}