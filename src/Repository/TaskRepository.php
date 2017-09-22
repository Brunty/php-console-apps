<?php declare(strict_types=1);

namespace App\Repository;

use App\Collection\TaskCollection;
use App\Entity\Task;

interface TaskRepository
{
    public function getAllTasks(): TaskCollection;

    public function getAllIncompleteTasks(): TaskCollection;

    public function find(string $id): Task;

    public function save(Task $task): void;
}
