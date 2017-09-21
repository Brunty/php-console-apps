<?php

namespace App\Spec\Entity;

use App\Entity\Task;
use App\Value\Uuid;

describe(Task::class, function() {
    it('can be constructed', function() {
        $task = new Task(new Uuid, 'Todo');

        expect($task->getName())->toBe('Todo');
        expect($task->getId())->toBeAnInstanceOf(Uuid::class);
    });

    it('can be constructed with only name', function() {
        $task = Task::fromName('Todo');

        expect($task->getName())->toBe('Todo');
        expect($task->getId())->toBeAnInstanceOf(Uuid::class);
    });

    it('can change its name', function() {
        $task = Task::fromName('Todo');
        $task = $task->changeName('New name');

        expect($task->getName())->toBe('New name');
        expect($task)->toBeAnInstanceOf(Task::class);
    });

    it('is not complete by default', function() {
        $task = Task::fromName('Todo');

        expect($task->isComplete())->toBe(false);
    });

    it('can be completed', function() {
        $task = Task::fromName('Todo');
        $task = $task->complete();

        expect($task->isComplete())->toBe(true);
        expect($task)->toBeAnInstanceOf(Task::class);
    });
});
