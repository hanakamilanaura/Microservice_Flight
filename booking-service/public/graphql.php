<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\GraphQL\Controller\GraphQLController;

$controller = new GraphQLController();
$controller->handle(); 