<?php

namespace Kanboard\Plugin\SqliteWorkarounds;

use Kanboard\Core\Plugin\Base;
use Kanboard\Plugin\SqliteWorkarounds\Model\NewTaskTagModel;

class Plugin extends Base
{
    // https://sqlite.org/limits.html#max_variable_number
    const SQLITE_MAX_VARIABLE_NUMBER = 999;

    public function initialize()
    {
        //  New TaskTagModel
        $this->container['taskTagModel'] = $this->container->factory(function ($c) {
            $newTaskTagModel = new NewTaskTagModel($c);
            return $newTaskTagModel->withSqliteMaxVariableNumber(self::SQLITE_MAX_VARIABLE_NUMBER);
        });
    }

    public function getPluginName()
    {
        return "Sqlite Workarounds";
    }

    public function getPluginDescription()
    {
        return 'Workarounds to bypass sqlite limits';
    }

    public function getPluginAuthor()
    {
        return 'Rafael de Camargo';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/rafacamargo123/plugin-kanboard-sqlite-workaround';
    }
}
