<?php
namespace Flownative\BeachFlowCompanion;

use Flownative\BeachFlowCompanion\Cache\PdoBackend as CompanionPdobackend;
use Neos\Cache\Exception\NoSuchCacheException;
use Neos\Flow\Cache\CacheManager;
use Neos\Flow\Command\CacheCommandController;
use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Exception;

/**
 * Class Package
 */
class Package extends \Neos\Flow\Package\Package
{
    /**
     * @param Bootstrap $bootstrap
     */
    public function boot(Bootstrap $bootstrap)
    {
        $dispatcher = $bootstrap->getSignalSlotDispatcher();
        $dispatcher->connect(
            CacheCommandController::class,
            'warmupCaches',
            function() use ($bootstrap) {
                try {
                    $cacheManager = $bootstrap->getObjectManager()->get(CacheManager::class);
                    foreach ($cacheManager->getCacheConfigurations() as $cacheIdentifier => $cacheConfiguration) {
                       if (isset($cacheConfiguration['backend']) && $cacheConfiguration['backend'] === CompanionPdobackend::class) {
                           try {
                               $cacheManager->getCache($cacheIdentifier)->getBackend()->createTableIfNeeded();
                           } catch (NoSuchCacheException $e) {
                           }
                       }
                    }
                } catch (Exception $e) {
                    echo $e->getMessage() . "\n";
                }
            }
        );
    }
}
