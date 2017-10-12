<?php
return array(
    'host'    => '127.0.0.1',
    'port'    => 9312,
    'timeout' => 30,
    'indexes' => array(
        'blog' => array('table' => 'blog_search_index', 'column' => 'id'),
    ),
    'mysql_server' => array(
        'host' => '127.0.0.1',
        'port' => 9306
    )
);
