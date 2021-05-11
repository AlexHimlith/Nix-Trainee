<?php


namespace controllers;


interface UserContInterface
{
    public function actionLogin();
    public function actionRegistration();
    public function actionSignin();
    public function actionNewUser();
    public function actionProfile();
    public function actionImage();
    public function actionExit();
}