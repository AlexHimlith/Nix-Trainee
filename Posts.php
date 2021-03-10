<?php



class Posts
{

    public static function getListPosts()
    {
        $posts = json_decode(file_get_contents(FILENAME), TRUE);
        $content = "<div id='all_posts'>";

        foreach ($posts as $key => $post)
        {
            //debug($post['title']);
            //debug($post['text']);
            $content .= "<div class='post'>
                            <div>
                                <span>Title:</span> <div>{$post['title']}</div>
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
return <<<NPST
    <form id="form_post" method="post" action="addpost">
                
        <label><span>Title:<em>*</em></span>
            <input type="text" name="title" required>
        </label>
                               
        <label><span>Text:</span>
            <textarea name="text"></textarea>
        </label>

        <input type="submit" value="Post">

    </form>
NPST;
    }

    public static function getNewPost()
    {
        $post = array();
        if (isset($_POST['title']))
        {
            $title = htmlentities($_POST['title']);
            $txt = htmlspecialchars($_POST['text']);

            $post = ['title'=>$title, 'text' => $txt];
        }
        return $post;
    }
}