<?php

use App\Properties\PropertySetter;

describe(PropertySetter::class, function () {
    it('sets a private property', function () {
        $obj = new class {
            private $foo;

            public function getFoo()
            {
                return $this->foo;
            }
        };

        $obj = PropertySetter::set($obj, 'foo', 'bar');

        expect($obj->getFoo())->toBe('bar');
    });
});
