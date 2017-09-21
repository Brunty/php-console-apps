<?php

namespace App\Factory;

class PDOFactory
{
    public static function createFromUrl(string $url): \PDO
    {
        if (($parts = parse_url($url)) === false) {
            throw new \InvalidArgumentException('Could not parse URL');
        }

        [
            'scheme' => $scheme,
            'host' => $host,
            'user' => $username,
            'pass' => $password,
            'port' => $port,
            'path' => $database,
        ] = $parts;

        $database = trim($database, '/');

        return new \PDO("$scheme:host=$host;port=$port;dbname=$database", $username, $password);
    }
}
