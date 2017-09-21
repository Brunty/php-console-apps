<?php

namespace App\Spec\Entity;

use App\Value\Uuid;

describe(Uuid::class, function() {
    it('can be constructed', function() {
        $uuid = new \App\Value\Uuid;
        expect((string) $uuid)->toHaveLength(36);
    });

    it('can be constructed with a Uuid', function() {
        $uuid = new \App\Value\Uuid(\Ramsey\Uuid\Uuid::uuid4());
        expect((string) $uuid)->toHaveLength(36);
    });
});
