<?php


namespace core;

class Controller
{

    public $viewObj;

    function __construct($viewObj)
    {
        session_start();
        $viewObj = ucwords($viewObj);
        $viewObj = 'views\\'. $viewObj . 'View';
        $this->viewObj = new $viewObj;
    }
}