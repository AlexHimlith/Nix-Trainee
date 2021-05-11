<?php


namespace views;


class MainView extends \core\View implements MainViewInterface
{
    public function getMain()
    {
        return "<img id='start' src= '/views/img/forum1.png'>";
    }
}