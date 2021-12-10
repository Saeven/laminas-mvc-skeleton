<?php

use Doctrine\DBAL\Driver\PDO\MySQL\Driver;
use DoctrineExtensions\Query\Mysql\MatchAgainst;
use DoctrineExtensions\Query\Mysql\SubstringIndex;
use DoctrineExtensions\Query\Mysql\UtcTimestamp;
use DoctrineExtensions\Query\Mysql\UnixTimestamp;
use DoctrineExtensions\Query\Mysql\Date;

/**
 * Deployment database configuration
 */

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'generate_proxies' => true,
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'datetime_functions' => [
                    'date' => Date::class,
                    'unix_timestamp' => UnixTimestamp::class,
                    'utc_timestamp' => UtcTimestamp::class,
                ],
                'string_functions' => [
                    'substring_index' => SubstringIndex::class,
                    'match' => MatchAgainst::class,
                ],
            ],
        ],

        'connection' => [
            'orm_default' => [
                'driverClass' => Driver::class,
                'params' => [
                    'host' => '127.0.0.1',
                    'user' => 'skeleton',
                    'password' => 'skeleton',
                    'dbname' => 'skeleton',
                    'port' => '3306',
                    'driverOptions' => [
                        1002 => 'SET NAMES utf8',
                    ],
                ],
            ],
        ],
    ],
];
