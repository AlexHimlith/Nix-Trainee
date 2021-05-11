<?php


namespace views;


interface UserViewInterface
{
    public static function getFormLogin();
    public static function getFormRegistration();
    public static function getFormProfile($user);
    public static function getFormLoad();
}