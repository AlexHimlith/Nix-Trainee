<?php


namespace views;


 class PostView
{
    public static function getAllPost($posts)
    {
        $content = "<div id='all_posts'>";

        foreach ($posts as $key => $post)
        {
            //debug($post['title']);
            //debug($post['text']);

            $content .= "<div class='post'>
                            <div>
                                <span>Alias:</span> <div>{$post['title']}</div>
                                <span>Nick</span>
                                <span>Date:</span> <span>Datetime</span>
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
        $path = PROJECT_PATH . '/';
        return "<form id='form_post' method='post' action={$path}posts/addpost>
                
        <label><span>Title:<em>*</em></span>
            <input type='text' name='title' required>
        </label>
                               
        <label><span>Text:</span>
            <textarea name='text'></textarea>
        </label>

        <input type='submit' value='Post'>

        </form>";
    }

}