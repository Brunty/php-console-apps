<?php

namespace App\Spec\Repository;

use App\Entity\Task;
use App\Exception\TaskNotFoundException;
use App\Repository\MysqlTaskRepository;
use App\Repository\TaskRepository;
use function Brunty\Kahlan\PDO\reset;
use function Brunty\Kahlan\PDO\fixture;
use function \Kahlan\box;

describe(MysqlTaskRepository::class, function () {
    beforeEach(function () {
        reset('mysql:host=127.0.0.1;dbname=consoleworkshop', 'root', 'root');
        $this->repo = new MysqlTaskRepository(box('db.pdo'));
    });

    it('is an instance of App\Repository\TaskRepository', function () {
        expect($this->repo)->toBeAnInstanceOf(TaskRepository::class);
    });

    context('when there are no tasks in the database', function () {
        it('gets no tasks from the database if there are none', function () {
            expect($this->repo->getAllTasks())->toHaveLength(0);
        });

        it('gets no incomplete tasks from the database if there are none', function () {
            expect($this->repo->getAllIncompleteTasks())->toHaveLength(0);
        });
    });

    context('when there are tasks in the database', function () {
        beforeEach(function () {
            fixture('tasks');
        });

        it('gets all tasks from the database', function () {
            expect($this->repo->getAllTasks())->toHaveLength(3);
        });

        it('gets all incomplete tasks from the database', function () {
            expect($this->repo->getAllIncompleteTasks())->toHaveLength(2);
        });
    });

    context('when a task is to be retrieved', function () {
        beforeEach(function () {
            fixture('tasks');
        });

        it('throws an exception if it cannot find a task by id', function () {
            $fn = function () {
                $this->repo->find('abc');
            };

            expect($fn)->toThrow(new TaskNotFoundException('Could not find task with id abc'));
        });

        it('gets a task by id', function () {
            /** @var Task $task */
            $task = $this->repo->find('b1b0c0ce-cc9c-458e-b648-de19e0aac496');

            expect($task->getName())->toBe('Task 3');
            expect($task->getAddedOn()->format('Y-m-d H:i:s'))->toBe('2016-10-07 01:02:03');
            expect($task->isComplete())->toBe(true);
        });
    });

    context('when a task is to be saved', function () {
        it('saves a new task', function () {
            $task = Task::fromName('Task to be saved');

            $this->repo->save($task);

            $tasks = $this->repo->getAllTasks();

            /** @var Task $task */
            $task = $tasks[0];

            expect($task->getName())->toBe('Task to be saved');
            expect($task->isComplete())->toBe(false);
        });

        it('updates an existing task', function () {
            fixture('tasks');

            /** @var Task $task */
            $task = $this->repo->find('095ae2fb-cf7b-4dcd-829f-e10e3ce84a3d');
            $task->complete();
            $task->changeName('Task 1 Updated');

            $this->repo->save($task);

            /** @var Task $updatedTask */
            $updatedTask = $this->repo->find('095ae2fb-cf7b-4dcd-829f-e10e3ce84a3d');

            expect($updatedTask->getName())->toBe('Task 1 Updated');
            expect($updatedTask->isComplete())->toBe(true);
        });
    });
});
