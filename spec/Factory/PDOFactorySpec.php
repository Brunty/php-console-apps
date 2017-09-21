<?php

namespace App\Spec\Factory;

use App\Factory\PDOFactory;

describe(PDOFactory::class, function () {
    context('given a correct URL', function () {
        it('will create a PDO object', function () {
            $pdo = PDOFactory::createFromUrl(getenv('DB_URL'));
            expect($pdo)->toBeAnInstanceOf(\PDO::class);
        });
    });

    context('given a malformed URL', function () {
        it('will not create a PDO object', function () {
            $fn = function () {
                PDOFactory::createFromUrl('mysql://carter:pa:asd:asd:55w0rd@host:port');
            };
            expect($fn)->toThrow(new \InvalidArgumentException('Could not parse URL'));
        });
    });
});
