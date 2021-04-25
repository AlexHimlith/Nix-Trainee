<?php


namespace views;

use core\View;

class PostsView extends View
{
    public static function getAllPost($posts)
    {
        //debug($posts);
        $content = "<div id='all_posts'>";

        foreach ($posts as $key => $post)
        {
            //debug($post['title']);
            //debug($post['text']);

            $content .= "<div class='post'>
                            <div>
                                <span>Title:</span> <div>{$post['title']}</div>
                                <span>{$post['nick']}</span>
                                <span>Date:</span> <span>{$post['date']}</span>
                            </div>
                            <div>
                                {$post['text']}
                            </div>
                        </div>";
        }
        $content .= "</div>";
        return $content;
    }

    public static function getFormNewPost()
    {
        return "<form id='form_post' method='post' action='/posts/addpost'>
                
        <label><span>Title:<em>*</em></span>
            <input type='text' name='title' required>
        </label>
                               
        <label><span>Text:</span>
            <textarea name='text'></textarea>
        </label>

        <input type='submit' value='Post'>

        </form>";
    }

    /*public static function render($content)
    {
        include DEFAULT_VIEW;
    }*/

}