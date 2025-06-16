<?php

namespace App\GraphQL;

use GraphQL\Type\Schema as GraphQLSchema;
use App\GraphQL\Type\QueryType;
use App\GraphQL\Type\MutationType;

class Schema
{
    private static $queryType;
    private static $mutationType;
    private static $schema;

    public static function getQueryType()
    {
        return self::$queryType ?: (self::$queryType = new QueryType());
    }

    public static function getMutationType()
    {
        return self::$mutationType ?: (self::$mutationType = new MutationType());
    }

    public static function getSchema()
    {
        return self::$schema ?: (self::$schema = new GraphQLSchema([
            'query' => self::getQueryType(),
            'mutation' => self::getMutationType()
        ]));
    }
} 