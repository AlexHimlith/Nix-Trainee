<?php


namespace views;


use core\View;

class UserView extends View
{
    public static function getFormLogin()
    {
        return "
            <form id='form_login' method='post' action='/user/signin'>
                        
                <label><span>Nick or e-mail:</span>
                    <input type='text' name='nick' placeholder='JDoe' required>
                </label>
                                       
                <label><span>Pass:</span>
                    <input type='password' name='pass' placeholder='password' required>
                </label>
        
                <input type='submit' value='Login'>
            </form>
            <div><a href='/user/registration'>Registration</a></div>";
    }

    public static function getFormRegistration()
    {
        return "
            <form id='form_registration' method='post' action='/user/newuser'>
                    <label><span>Nick:<em>*</em></span>
                        <input type='text' name='nick' id='nick' placeholder='JDoe' required>
                    </label>
                                    
                    <label><span>E-mail:<em>*</em></span>
                        <input type='email' name='email' id='email' placeholder='JohnDoe@gmail.com' required>
                    </label>
                    
                    <label><span>Password:<em>*</em></span>
                        <input type='password' name='pass1' id='pass1' required>
                    </label>
                    
                    <label><span>Confirm Password:<em>*</em></span>
                        <input type='password' name='pass2' id='pass2' required>
                    </label>
    
                    <input type='submit' value='Register' id='login_btn'>
            </form>";
    }

    public static function getFormProfile($user)
    {
        /*return "
            <div id='form'>
            <div id='img'>
                <a href='/user/image'><img src='/views/img/{$user['img']}'></a>
            </div>
            <form id='form_profile' method='post' action='/user/profile'>
                    <h3>{$_SESSION['nick']}</h3>
                    <label><span>First Name:</span>
                        <input type='text' name='name' id='name' placeholder='John' value='{$user['name']}'>
                    </label>
                                       
                    <label><span>Surname:</span>
                        <input type='text' name='surname' id='surname' placeholder='Doe' value='{$user['surname']}'>
                    </label>
                                        
                    <label><span>Nick:</span>
                        <input type='text' name='nick' id='nick' value='{$_SESSION['nick']}' required>
                    </label>
                                        
                    <label><span>E-mail:</span>
                        <input type='email' name='email' id='email' value='{$_SESSION['email']}' required>
                    </label>
                     
                    <label><span>New password:</span>
                        <input type='password' name='pass1' id='pass1'>
                    </label>
                       
                    <label><span>Confirm Password:</span>
                        <input type='password' name='pass2' id='pass2'>
                    </label>
        
                    <label><span>Date of Birth:</span>
                        <input type='date' name='datebirth' id='datebirth' value='{$user['date']}'>
                    </label>
        
                    <label><span>Place:</span>
                        <input type='text' name='place' id='place' placeholder='Kharkiv' value='{$user['place']}'>
                    </label>
        
                    <input type='submit' value='Change' id='profile_btn'>

            </form>
            </div>";*/


        return "
            <form id='form_profile' method='post' action='/user/profile'>
                    <h3>{$_SESSION['nick']}</h3>
                    
                    <a href='/user/image'><img src='/views/img/{$user['img']}'></a>
                    
                    <div>
                        <label><span>First Name:</span>
                            <input type='text' name='name' id='name' placeholder='John' value='{$user['name']}'>
                        </label>
                                       
                        <label><span>Surname:</span>
                            <input type='text' name='surname' id='surname' placeholder='Doe' value='{$user['surname']}'>
                        </label>
                                        
                        <label><span>Nick:</span>
                            <input type='text' name='nick' id='nick' value='{$_SESSION['nick']}' required>
                        </label>
                                        
                        <label><span>E-mail:</span>
                            <input type='email' name='email' id='email' value='{$_SESSION['email']}' required>
                        </label>
                        
                        <label><span>New password:</span>
                            <input type='password' name='pass1' id='pass1'>
                        </label>
                        
                        <label><span>Confirm Password:</span>
                            <input type='password' name='pass2' id='pass2'>
                        </label>
        
                        <label><span>Date of Birth:</span>
                            <input type='date' name='datebirth' id='datebirth' value='{$user['date']}'>
                        </label>
        
                        <label><span>Place:</span>
                            <input type='text' name='place' id='place' placeholder='Kharkiv' value='{$user['place']}'>
                        </label>
        
                        <input type='submit' value='Change' id='profile_btn'>
                    </div>
            </form>";
    }

    public static function getFormLoad()
    {
        return "<form id='form_load' method='post' enctype='multipart/form-data'>
            <p>Only PNG ang JPEG files</p>
            <p><input type='file' name='file'></p>
            <input type='submit' value='Upload' id='load_btn'>
        </form>";
    }
}