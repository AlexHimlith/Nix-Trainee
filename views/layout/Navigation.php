<?php

namespace views\layout;

class Navigation
{
    public static function getMenu()
    {
        $path = PROJECT_PATH;
        return "<nav>
                <a href= {$path}/>Home</a>
                <a href={$path}/posts>Posts</a>
                <a href={$path}/posts/new>New Post</a>
                </nav>";
    }
}