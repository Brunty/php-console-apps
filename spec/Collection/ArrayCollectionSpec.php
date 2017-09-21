<?php declare(strict_types=1);

namespace App\Spec\Collection;

use App\Collection\ArrayCollection;
use ArrayAccess;
use Countable;
use IteratorAggregate;

describe(ArrayCollection::class, function () {
    describe('interfaces are implemented on the class', function () {
        it('implements ArrayAccess', function () {
            expect(new ArrayCollection)->toBeAnInstanceOf(ArrayAccess::class);
        });

        it('implements IteratorAggregate', function () {
            expect(new ArrayCollection)->toBeAnInstanceOf(IteratorAggregate::class);
        });

        it('implements Countable', function () {
            expect(new ArrayCollection)->toBeAnInstanceOf(Countable::class);
        });
    });

    describe('\ArrayAccess is implemented', function () {
        it('implements the \ArrayAccess methods correctly', function () {
            $collection = new ArrayCollection([
                'item1',
                'item2',
                'foo' => 'bar',
                'baz' => 'bingo',
                'unsetthis' => 'thing',
            ]);

            $collection['ping'] = 'pong';
            $collection['baz'] = 'boz';
            $collection[] = 'appended';
            unset($collection['unsetthis']);

            expect($collection['ping'])->toBe('pong');
            expect($collection['thiskeydoesnotexist'])->toBeNull();
            expect($collection['unsetthis'])->toBeNull();
        });

        it('can check whether things are set as if it were an array', function () {
            $collection = new ArrayCollection(['foo' => 'bar']);

            expect(isset($collection['foo']))->toBe(true);
            expect(isset($collection['thiskeydoesnotexist']))->toBe(false);
        });

        it('can add items to the collection like it were an array', function () {
            $collection = new ArrayCollection(['item1', 'item2', 'foo' => 'bar']);
            $collection['ping'] = 'pong';

            expect($collection['ping'])->toBe('pong');
        });

        it('can unset items in the collection like it were an array', function () {
            $collection = new ArrayCollection(['item1', 'item2', 'foo' => 'bar']);
            unset($collection['foo']);

            expect($collection['foo'])->toBeNull();
            expect($collection->toArray())->toBe(['item1', 'item2']);
        });
    });

    describe('\IteratorAggregate is implemented', function () {
        it('returns an iterator with the correct collection items', function () {
            $collection = new ArrayCollection(['item1', 'item2']);

            expect($collection->getIterator())->toBeAnInstanceOf(\ArrayIterator::class);
            expect($collection->getIterator())->toHaveLength(2);
        });
    });

    describe('\Countable is implemented', function () {
        it('is countable', function () {
            $collection = new ArrayCollection(['item1', 'item2']);

            expect($collection)->toHaveLength(2);
        });
    });

    it('returns the collection as an array', function () {
        $array = ['foo' => ['bar' => 'baz']];
        $collection = new ArrayCollection($array);

        expect($collection->toArray())->toBe($array);
    });

    it('can add an item to the collection', function () {
        $collection = new ArrayCollection;
        $collection->add('item');

        expect($collection->toArray())->toBe(['item']);
    });

    it('can remove an item from the collection by an unspecified key', function () {
        $collection = new ArrayCollection(['item1', 'foo' => 'bar']);
        $item = $collection->remove(0);

        expect($item)->toBe('item1');
        expect($collection->get('item1'))->toBeNull();
        expect($collection->toArray())->toBe(['foo' => 'bar']);
    });

    it('can remove an item from the collection by a specified key', function () {
        $collection = new ArrayCollection(['item1', 'foo' => 'bar']);
        $item = $collection->remove('foo');

        expect($item)->toBe('bar');
        expect($collection->get('foo'))->toBeNull();
        expect($collection->toArray())->toBe(['item1']);
    });

    it('returns false if the item to remove does not exist', function () {
        $collection = new ArrayCollection(['item1', 'foo' => 'bar']);
        $item = $collection->remove('bing');

        expect($item)->toBe(false);
        expect($collection->toArray())->toBe(['item1', 'foo' => 'bar']);
    });

    it('maps a function to the collection', function () {
        $collection = new ArrayCollection(['item1', 'item2']);
        $results = $collection->map(
            function ($item) {
                return $item . 's';
            }
        );

        expect($results->toArray())->toBe(['item1s', 'item2s']);
        expect($results)->toBeAnInstanceOf(ArrayCollection::class);
        expect($results)->not->toBe($collection); // ensure that we have a new object back
    });

    it('filters the collection', function () {
        $collection = new ArrayCollection(['item1', 'item2']);
        $results = $collection->filter(
            function ($item) {
                return $item === 'item1';
            }
        );

        expect($results->toArray())->toBe(['item1']);
        expect($results)->toBeAnInstanceOf(ArrayCollection::class);
        expect($results)->not->toBe($collection); // ensure that we have a new object back
    });

    it('clears the collection', function () {
        $collection = new ArrayCollection(['item1', 'item2']);
        $collection->clear();

        expect($collection->toArray())->toBe([]);
    });

    it('can chain multiple methods together', function () {
        $collection = new ArrayCollection(['foo' => 'bar', 'bar' => 'baz']);
        $results = $collection->map(
            function ($value) {
                return $value . 's';
            }
        )->filter(
            function ($value) {
                return $value === 'bars';
            }
        );

        expect($results->toArray())->toBe(['foo' => 'bars']);
        expect($results)->toBeAnInstanceOf(ArrayCollection::class);
        expect($results)->not->toBe($collection); // ensure that we have a new object back
    });

    it('checks whether the collection contains an item', function () {
        $collection = new ArrayCollection(['item1', 'foo' => 'bar']);

        expect($collection->contains('bar'))->toBe(true);
        expect($collection->contains('baz'))->toBe(false);
    });

    it('slices the collection', function () {
        $collection = new ArrayCollection(['item1', 'item2', 'foo' => 'bar', 'item3']);
        $results = $collection->slice(0, 3);

        expect($results->toArray())->toBe(['item1', 'item2', 'foo' => 'bar']);
        expect($results)->toBeAnInstanceOf(ArrayCollection::class);
        expect($results)->not->toBe($collection); // ensure that we have a new object back
    });

    it('tells you if the collection is empty', function () {
        $collection = new ArrayCollection([]);

        expect($collection->isEmpty())->toBe(true);
    });

    it('tells you if the collection is not empty', function () {
        $collection = new ArrayCollection(['1']);

        expect($collection->isEmpty())->toBe(false);
    });
});
