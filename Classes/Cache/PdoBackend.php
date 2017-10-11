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
     * Sets the DSN to use
     *
     * @param string $DSN The DSN to use for connecting to the DB
     * @return void
     * @api
     */
    public function setDataSourceName(string $DSN)
    {
        $this->dataSourceName = getenv($DSN);
    }

    /**
     * Sets the username to use
     *
     * @param string $username The username to use for connecting to the DB
     * @return void
     * @api
     */
    public function setUsername(string $username)
    {
        $this->username = getenv($username);
    }

    /**
     * Sets the password to use
     *
     * @param string $password The password to use for connecting to the DB
     * @return void
     * @api
     */
    public function setPassword(string $password)
    {
        $this->password = getenv($password);
    }

    /**
     *
     * @throws \Neos\Cache\Exception
     * @throws Exception
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

