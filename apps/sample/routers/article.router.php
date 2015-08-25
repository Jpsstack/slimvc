<?php
$app->get('/article/:id', 'ArticleController:get')->name('article:get-by-id');
$app->delete('/article/:id', 'ArticleController:delete')->name('article:delete');
$app->get('/admin/article/:id', 'Admin\ArticleController:get');