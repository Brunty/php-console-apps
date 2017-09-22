<?php declare(strict_types=1);

namespace App\Repository;

use App\Collection\TaskCollection;
use App\Entity\Task;
use App\Exception\TaskNotFoundException;
use App\Properties\PropertySetter;
use App\Value\Uuid;

final class MysqlTaskRepository implements TaskRepository
{

    /**
     * @var \PDO
     */
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getAllTasks(): TaskCollection
    {
        $stmt = $this->db->query('SELECT * FROM Tasks');
        $tasks = $stmt->fetchAll();

        return $this->mapTasks($tasks);
    }

    public function getAllIncompleteTasks(): TaskCollection
    {
        $stmt = $this->db->query('SELECT * FROM Tasks WHERE complete = 0');
        $tasks = $stmt->fetchAll();

        return $this->mapTasks($tasks);
    }

    public function find(string $id): Task
    {
        $stmt = $this->db->prepare('SELECT * FROM Tasks WHERE id = :task_id');
        $stmt->execute(['task_id' => $id]);
        $task = $stmt->fetch();

        if ($task === false) {
            throw new TaskNotFoundException("Could not find task with id {$id}");
        }

        return $this->mapTask($task);
    }

    public function save(Task $task): void
    {
        try {
            $this->updateTask($task);
        } catch (TaskNotFoundException $e) {
            $this->insertTask($task);
        }
    }

    private function mapTasks(array $tasks): TaskCollection
    {
        return new TaskCollection(array_map(function ($task) {
            return $this->mapTask($task);
        }, $tasks));
    }

    private function mapTask(array $data): Task
    {
        $task = new Task(
            new Uuid($data['id']),
            $data['name']
        );

        PropertySetter::set($task, 'addedOn', new \DateTimeImmutable($data['added_on']));

        if (isset($data['complete']) && (int) $data['complete'] === 1) {
            $task->complete();
        }

        return $task;
    }

    private function updateTask(Task $task): void
    {
        $this->find((string) $task->getId());

        $sql = <<<SQL
UPDATE Tasks
SET name = :task_name, complete = :complete
WHERE id = :task_id
SQL;

        $params = [
            'task_name' => $task->getName(),
            'complete' => $task->isComplete() ? 1 : 0,
            'task_id' => (string) $task->getId(),
        ];

        $this->executeSql($sql, $params);
    }

    private function insertTask(Task $task): void
    {
        $sql = <<<SQL
INSERT INTO Tasks (id, name, added_on, complete) 
VALUES(:task_id, :task_name, :added_on, :complete)
SQL;
        $params = $this->mapParams($task);

        $this->executeSql($sql, $params);
    }

    private function executeSql($sql, $params): bool
    {
        return $this->db->prepare($sql)->execute($params);
    }

    private function mapParams(Task $task): array
    {
        return [
            'task_id' => (string) $task->getId(),
            'task_name' => $task->getName(),
            'added_on' => $task->getAddedOn()->format('Y-m-d H:i:s'),
            'complete' => $task->isComplete() ? 1 : 0,
        ];
    }
}
