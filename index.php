<?php

declare(strict_types=1);
$projectRoot = __DIR__;

error_reporting(E_ALL);
ini_set('display_errors', "1");

require_once 'Helpers/RenderHelper.php';
require_once 'sample_data.php';

use Helpers\RenderHelper;

$renderHelper = new RenderHelper();

$title = "Page Title";

$columns = [
    'display_name' => 'Name',
    'user_email' => 'Email ID',
    'user_status' => 'Status',

];

$sortables = [
    'display_name'
];

$filterbales = [
    [
        'key' => 'user_status',
        'display_name' => 'Status Filter',
        'values' => [
            '0' => 'Active',
            '1' => 'Inactive',
        ]
    ],
    [
        'key' => 'another_status',
        'display_name' => 'Another Status Filter',
        'values' => [
            '0' => 'Active',
            '1' => 'Inactive',
        ]
    ]
];

$perPageItems = [
    10,
    20,
    50,
    100
];

$queryParams = $_GET;


$renderHelper->render(
    'table',
    compact(
        'title',
        'columns',
        'sortables',
        'filterbales',
        'queryParams',
        'data',
        'perPageItems'
    )
);