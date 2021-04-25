<?php


namespace views;


use core\View;

class UserView extends View
{
    public static function getFormLogin($end_session = false)
    {
        if ($end_session)
        {
            $content = "<p>Session timed out.</p><br>";
        }
        else
            {
                $content = '';
            }
        return "$content
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
                    
                    <!--<label><span>First Name:<em>*</em></span>
                        <input type='text' name='name' id='name' placeholder='John' required>
                    </label>
                                   
                    <label><span>Surname:<em>*</em></span>
                        <input type='text' name='surname' id='surname' placeholder='Doe' required>
                    </label>-->
                                    
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
    
                    <!--<label><span>Date of Borth:</span>
                        <input type='date' name='dateborth' id='dateborth'>
                    </label>
    
                    <label><span>Place:</span>
                        <input type='text' name='place' id='place' placeholder='Kharkiv'>
                    </label>-->
    
                    <input type='submit' value='Register' id='login_btn'>
            </form>";
    }
}