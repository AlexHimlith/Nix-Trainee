<?php


class Header
{

    /** Возвращает содержимое тега header с указанным заглавием
     * @param string $header заглавие сайта
     * @return string html с содержимым тэга header
     */
    public static function getHeader($header = 'HEADER')
    {

        //ob_start();
    return "<div>&nbsp;</div>
            <h1> {$header} </h1>
            <div><a href='#'>Login</a></div>";
    }

}