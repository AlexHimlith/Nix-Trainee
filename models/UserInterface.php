<?php


namespace models;


interface UserInterface
{
    public static function newUser();
    public static function loginUser();
    public static function exitUser();
    public static function profileUser();
    public static function updateProfile();
    public static function uploadImage();
}