<?php

namespace App\Components\Domain\Case;

use App\Components\App\Tasks\Handlers\PostHistoryComment;
use App\Components\Domain\Helpers\JWTHelper;
use App\Components\Domain\ValueObjects\PostHistoryCommentValueObject;
use App\Components\Domain\ValueObjects\TaskValueObject;
use App\Components\Infrastructure\MySQL\Queries\Stores\GetAllStoresQuery;
use App\Components\Infrastructure\MySQL\Queries\Stores\GetStoreChars;
use App\Components\Infrastructure\MySQL\Queries\Stores\GetStoreCharsQuery;
use App\Components\Infrastructure\MySQL\Queries\Tasks\AddTaskQuery;
use App\Components\Infrastructure\MySQL\Queries\Tasks\EditTaskQuery;
use App\Components\Infrastructure\MySQL\Queries\Tasks\GetAllTasksQuery;
use App\Components\Infrastructure\MySQL\Queries\Tasks\GetStoreCharsByTaskIds;
use App\Components\Infrastructure\MySQL\Queries\Tasks\GetTaskHistoryDetailQuery;
use App\Components\Infrastructure\MySQL\Queries\Tasks\GetTaskQuery;
use App\Components\Infrastructure\MySQL\Queries\Tasks\GetTasksHistoryQuery;
use App\Components\Infrastructure\MySQL\Queries\Tasks\PostHistoryComment as TasksPostHistoryComment;
use App\Components\Infrastructure\MySQL\Queries\Tasks\PostHistoryCommentQuery;
use App\Components\Infrastructure\MySQL\Queries\Tasks\RemoveTaskQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\GetSelectedUsersQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\GetUserCompanyDBInformation;
use App\Components\Infrastructure\MySQL\Queries\Users\GetAllUsersQuery;
use Dibi\Exception;
use Dibi\Row;

class TasksCase
{
    private AddTaskQuery $addTaskQuery;
    private EditTaskQuery $editTaskQuery;
    private GetAllTasksQuery $getAllTasksQuery;
    private GetTaskQuery $getTaskQuery;
    private RemoveTaskQuery $removeTaskQuery;
    private GetTasksHistoryQuery $getTasksHistoryQuery;
    private GetUserCompanyDBInformation $getUserCompanyDBInformation;
    private GetSelectedUsersQuery $getSelectedUsersQuery;
    private GetTaskHistoryDetailQuery $getTaskHistoryDetailQuery;
    private Row $companyDBInfo;

    public function __construct(
        AddTaskQuery $addTaskQuery,
        EditTaskQuery $editTaskQuery,
        GetAllTasksQuery $getAllTasksQuery,
        GetTaskQuery $getTaskQuery,
        GetUserCompanyDBInformation $getUserCompanyDBInformation,
        RemoveTaskQuery $removeTaskQuery,
        GetSelectedUsersQuery $getSelectedUsersQuery,
        GetTaskHistoryDetailQuery $getTaskHistoryDetailQuery,
        GetTasksHistoryQuery $getTasksHistoryQuery,
        private GetAllStoresQuery $getAllStoresQuery,
        private GetStoreCharsByTaskIds $getStoreCharsByTaskIds,
        private GetStoreCharsQuery $getStoreCharsQuery,
        private GetAllUsersQuery $getAllUsersQuery,
        private PostHistoryCommentQuery $postHistoryCommentQuery,
    )
    {
        $this->addTaskQuery = $addTaskQuery;
        $this->editTaskQuery = $editTaskQuery;
        $this->getAllTasksQuery = $getAllTasksQuery;
        $this->getTaskQuery = $getTaskQuery;
        $this->removeTaskQuery = $removeTaskQuery;
        $this->getSelectedUsersQuery = $getSelectedUsersQuery;
        $this->getUserCompanyDBInformation = $getUserCompanyDBInformation;
        $this->getTasksHistoryQuery = $getTasksHistoryQuery;
        $this->getTaskHistoryDetailQuery = $getTaskHistoryDetailQuery;
        $this->companyDBInfo = $this->getCompanyDBInfo();
    }


    /**
     * @throws Exception
     * @throws \Exception
     */
    public function getAllTasks(): ?string
    {
        $tasks = $this->getAllTasksQuery->execute($this->companyDBInfo['dbName']);
        $taskIds = [];

        foreach ($tasks as $task) {
            array_push($taskIds, $task['id']);
        }

        $allStoreChars = json_decode($this->getStoreCharsQuery->execute($this->companyDBInfo['dbName']), true);
        $storesCount = sizeof($this->getAllStoresQuery->execute($this->companyDBInfo['dbName']));
        $countOfCharCombinations = [];

        foreach ($allStoreChars as $char) {
            $charName = $char["attribute"] . ":" . $char["value"];
            if (isset($countOfCharCombinations[$charName]) === false) {
                $countOfCharCombinations[$charName] = 0;
            }
            $countOfCharCombinations[$charName] += 1;
        }

        $storeChars = $this->getStoreCharsByTaskIds->execute($taskIds, $this->companyDBInfo['dbName']);
        $storeCountByIndex = [];

        foreach($storeChars as $index => $storeChar) {
            $storeChar = json_decode($storeChar, true);
            $loop = $storeChar['storeChars'];

            foreach($loop as $char) {
                if (!isset($storeCountByIndex[$index])) {
                    $storeCountByIndex[$index] = 0;
                }

                $charName = $char['attribute']['name'] . ':' . $char['value']['name'];
                $storeCountByIndex[$index] += (!isset($countOfCharCombinations[$charName])) ? 0 : $countOfCharCombinations[$charName];
            }
        }

        foreach ($tasks as $task) {
            if (\array_key_exists($task['id'], $storeCountByIndex)) {
                $task['store_count'] = $storeCountByIndex[$task['id']];
            } else {
                $task['store_count'] = $storesCount;
            }
        }

        return \json_encode($tasks);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function RemoveTask(int $id): void
    {
        $this->removeTaskQuery->execute($id, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function addTask(TaskValueObject $vo): void
    {
        $this->addTaskQuery->execute($vo, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function editTask(TaskValueObject $vo, int $id): void
    {
        $this->editTaskQuery->execute($vo, $id, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function getTask(int $id): ?string
    {
        return $this->getTaskQuery->execute($id, $this->companyDBInfo['dbName']);
    }

    public function getAllHistoryTasks(): ?string
    {
        $userIds = [];
        $tasks = $this->getTasksHistoryQuery->execute($this->companyDBInfo['dbName']);

        foreach ($tasks as $task) {
            \array_push($userIds, $task['done_by_user']);
        }

        $fetchedUsers = $this->getSelectedUsersQuery->execute($userIds);
        $i = 0;

        foreach ($tasks as $task) {
            if ($task['done_by_user'] === null) {
                $tasks[$i]['user_name'] = null;
                $i++;
                continue;
            }

            $tasks[$i]['user_name'] = $fetchedUsers[$task['done_by_user']];
            $i++;
        }

        return \json_encode($tasks);
    }

    public function getSpecificHistoryTask(int $id): ?string
    {
        $taskDetails = $this->getTaskHistoryDetailQuery->execute($id, $this->companyDBInfo['dbName']);
        $stores = $this->getAllStoresQuery->execute($this->companyDBInfo['dbName']);
        $users = json_decode($this->getAllUsersQuery->execute(), true);
        $usersByID = [];
        $storeNames = [];

        foreach($stores as $store) {
            $storeNames[$store["id"]] = $store["store_name"];
        }

        foreach($users as $user) {
            $usersByID[$user['id']] = $user['name'];
        }

        foreach ($taskDetails as $taskDetail) {
            $taskDetail["store_name"] = $storeNames[$taskDetail["store_id"]];
            $taskDetail["created_by_user"] = $usersByID[$taskDetail["created_by_user"]];
            $taskDetail["done_by_user"] = $usersByID[$taskDetail["done_by_user"]];
            $taskDetail["origin_sender"] = $usersByID[$taskDetail["user_id"]];
        }

        return \json_encode($taskDetails);
    }

    public function postHistoryComment(PostHistoryCommentValueObject $vo, int $CommentId): void
    {
        $this->postHistoryCommentQuery->execute($vo, JWTHelper::getUserData()['id'], $CommentId, $this->companyDBInfo['dbName']);
    }

    private function getCompanyDBInfo(): Row
    {
        return $this->getUserCompanyDBInformation->execute(JWTHelper::getUserData()['id']);
    }
}
