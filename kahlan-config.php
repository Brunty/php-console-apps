<?php

use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

(new Dotenv)->load(__DIR__ . '/.env.test');

\Kahlan\box('db.path', __DIR__ . '/spec/db');
\Kahlan\box('db.path.sql', __DIR__ . '/spec/db/fixtures/sql');
\Kahlan\box('app.path', __DIR__);
