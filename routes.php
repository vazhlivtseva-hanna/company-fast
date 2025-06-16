<?php

return [
    'register.get' => [
        'controller' => 'RegisterController',
        'method' => 'showForm',
    ],
    'register.post' => [
        'controller' => 'RegisterController',
        'method' => 'submitForm',
    ],
    'login.get' => [
        'controller' => 'AuthController',
        'method' => 'showForm',
    ],
    'login.post' => [
        'controller' => 'AuthController',
        'method' => 'submitForm',
    ],
    'logout.get' => [
        'controller' => 'AuthController',
        'method' => 'logout',
    ],
    'dashboard.get' => [
        'controller' => 'IndexController',
        'method' => 'dashboard',
    ],
    'cow.get' => [
        'controller' => 'CowController',
        'method' => 'pageA',
    ],
    'api/cow.post' => [
        'controller' => 'Api\\CowController',
        'method' => 'buy',
    ],
    'download.get' => [
        'controller' => 'DownloadController',
        'method' => 'pageB',
    ],
    'download.post' => [
        'controller' => 'DownloadController',
        'method' => 'download',
    ],
    'statistics.get' => [
        'controller' => 'StatisticsController',
        'method' => 'index',
    ],
    'reports.get' => [
        'controller' => 'ReportsController',
        'method' => 'index',
    ],
];