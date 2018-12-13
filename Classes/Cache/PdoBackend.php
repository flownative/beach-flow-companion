<?php
namespace Flownative\BeachFlowCompanion\Cache;

use Neos\Flow\Exception;
use Neos\Utility\PdoHelper;

/**
 * Class PdoBackend
 */
class PdoBackend extends \Neos\Cache\Backend\PdoBackend
{
    /**
     * @param array $backendOptions
     */
    public function injectBackendOptions(array $backendOptions)
    {
        $port = '';
        if (isset($backendOptions['port'])) {
            $port = ';port=' . $backendOptions['port'];
        }

        $this->dataSourceName = sprintf(
            '%s:host=%s;dbname=%s%s',
            str_replace('pdo_', '', $backendOptions['driver']),
            $backendOptions['host'],
            $backendOptions['dbname'],
            $port
        );
        $this->username = $backendOptions['user'];
        $this->password = $backendOptions['password'];
    }

    /**
     * @return void
     * @throws Exception
     * @throws \Neos\Cache\Exception
     */
    public function createTableIfNeeded()
    {
        $this->connect();
        try {
            PdoHelper::importSql($this->databaseHandle, $this->pdoDriver,
                'resource://Flownative.BeachFlowCompanion/Private/CreateCacheTables.sql');
        } catch (\PDOException $exception) {
            throw new Exception('Could not create cache tables with DSN "' . $this->dataSourceName . '". PDO error: ' . $exception->getMessage(),
                1259576985);
        }
    }
}
