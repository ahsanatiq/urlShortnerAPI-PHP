<?php

$app->get('/', 'urlController@index');
$app->post('/', 'urlController@create');
$app->get('/{hashId}', 'urlController@redirectToTarget');
$app->post('/{hashId}', 'urlController@update');


