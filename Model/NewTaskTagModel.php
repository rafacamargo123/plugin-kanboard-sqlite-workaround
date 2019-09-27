<?php

namespace Kanboard\Plugin\SqliteWorkarounds\Model;

use Kanboard\Model\TagModel;
use Kanboard\Model\TaskTagModel;

class NewTaskTagModel extends TaskTagModel
{
    private $sqliteMaxVariableNumber = 999;

    public function withSqliteMaxVariableNumber($limit) {
        $this->sqliteMaxVariableNumber = $limit;
        return $this;
    }

    public function getTagsByTaskIds($task_ids)
    {
        if (empty($task_ids)) {
            return array();
        }

        $tags = [];
        $limit = $this->sqliteMaxVariableNumber;
        for ($offset = 0; $offset < count($task_ids); $offset+=$limit) {
            $sliced_task_ids = array_slice($task_ids, $offset, $limit);
            // cannot be array_merge_recursive because the ids are numeric and therefore are not preserved
            $tags += parent::getTagsByTaskIds($sliced_task_ids);
        }

        return $tags;
    }
}
