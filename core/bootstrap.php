<?php

/**
 * @var \MODX\Revolution\modX $modx
 * @var array $namespace
 */

use xPDO\xPDO;

// Add the service
try {
    // Add the package and model classes
    $modx->addPackage('SimpleExtra\Model', $namespace['path'] . 'src/', null, 'SimpleExtra\\');
}
catch (\Exception $e) {
    $modx->log(xPDO::LOG_LEVEL_ERROR, $e->getMessage());
}