<?php
    return
    [
        //Пустая строка - по умолчанию контроллер "Main". действие "index"
        '^$' => ['controller' => 'Main', 'action' => 'index'],
        //Любвя другая пара контроллер/действие(не обязательно)
        '^(?P<controller>[a-z]+)/?(?P<action>[a-z]+)?$' => [],
        /*'posts' => 'posts/list',
        'newpost' => 'posts/new'*/
    ];
