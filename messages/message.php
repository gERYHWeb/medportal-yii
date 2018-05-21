<?php

return [
    'sourcePath' => __DIR__ . '/../../',
    'messagePath' => __DIR__,
    'languages' => [
        'ru',
    ],
    'translator' => 'Yii::t',
    'sort' => false,
    'overwrite' => true,
    'removeUnused' => false,
    'only' => ['*.php'],
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        '/tests',
        '/vendor',
        '/lib',
        '/runtime',
        '/uploads',
        '/config',
        '/*.php'
    ],
    'format' => 'php',
    'ignoreCategories' => [
        'yii',
        'user',
        'content',
        'website-comments',
        'user-purse'
    ],
];
