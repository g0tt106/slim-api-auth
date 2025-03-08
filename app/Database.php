<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    public function __construct(
        private readonly string $driver,
        private readonly string $host,
        private readonly string $database,
        private readonly string $user,
        private readonly string $pass
    )
    {
    }

    public function getConnection(): PDO
    {
        $dsn = $this->driver . ':host=' . $this->host . ';dbname=' . $this->database;
        $user = $this->user;
        $pass = $this->pass;

        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }
}