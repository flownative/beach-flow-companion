<?php
namespace Flownative\BeachFlowCompanion\Cache;

use Neos\Flow\Exception;
use Neos\Flow\Annotations as Flow;
use Neos\Utility\PdoHelper;

/**
 * Class PdoBackend
 */
class PdoBackend extends \Neos\Cache\Backend\PdoBackend
{
    /**
     * @Flow\InjectConfiguration(path="persistence.backendOptions", package="Neos.Flow")
     * @var array
     */
    protected $backendOptions;

    /**
     *
     */
    public function initializeObject()
    {
        $this->dataSourceName = str_replace('pdo_','', $this->backendOptions['driver']) . ':host=' . $this->backendOptions['host'] . ';dbname=' . $this->backendOptions['dbname'];
        $this->username = $this->backendOptions['user'];
        $this->password = $this->backendOptions['password'];
        parent::initializeObject();
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
            PdoHelper::importSql($this->databaseHandle, $this->pdoDriver, 'resource://Flownative.BeachFlowCompanion/Private/CreateCacheTables.sql');
        } catch (\PDOException $exception) {
            throw new Exception('Could not create cache tables with DSN "' . $this->dataSourceName . '". PDO error: ' . $exception->getMessage(), 1259576985);
        }
    }
}
