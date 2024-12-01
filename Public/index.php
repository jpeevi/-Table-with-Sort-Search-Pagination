<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', "1");

require_once dirname(__DIR__) . '/Helpers/RenderHelper.php';
require_once dirname(__DIR__) . '/sample_data.php';

use Helpers\RenderHelper;

$renderHelper = new RenderHelper();

$title = "Page Title";

//The column name and their display counterpart
$columns = [
    'display_name' => 'Name',
    'user_email' => 'Email ID',
    'user_status' => 'Status',

];

//Columns that can be sorted
$sortables = [
    'display_name'
];

//Filters and their values
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

//Per page item values to display
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