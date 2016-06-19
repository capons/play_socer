<?php

class Validation
{
    private $data;
    protected function valid($el){
        $this->data = trim($el);
        $this->data = stripslashes($this->data);
        $this->data = htmlspecialchars($this->data);
        return $this->data;
    }

}