<?php
namespace Flownative\BeachFlowCompanion;

use Flownative\BeachFlowCompanion\Cache\PdoBackend;
use TYPO3\Flow\Cache\CacheManager;
use TYPO3\Flow\Cache\Exception\NoSuchCacheException;
use TYPO3\Flow\Command\CacheCommandController;
use TYPO3\Flow\Core\Bootstrap;
use TYPO3\Flow\Exception;

/**
 * Class Package
 */
class Package extends \TYPO3\Flow\Package\Package
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
                       if (isset($cacheConfiguration['backend']) && $cacheConfiguration['backend'] === PdoBackend::class) {
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
