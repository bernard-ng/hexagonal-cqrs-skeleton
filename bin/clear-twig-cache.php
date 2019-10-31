<?php
/**
 * Script for clearing the configuration cache.
 *
 * Can also be invoked as `composer clear-config-cache`.
 *
 * @see       https://github.com/zendframework/zend-expressive-skeleton for the canonical source repository
 * @copyright Copyright (c) 2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

chdir(__DIR__ . '/../');

$twigFolders = glob('data/cache/twig/*');
if (count($twigFolders) === 0) {
    echo "No configuration cache path found" . PHP_EOL;
    exit(0);
}
foreach ($twigFolders as $twigFolder) {
    $twigFiles = glob($twigFolder.'/*');
    foreach ($twigFiles as $twigFile) {
        if (!file_exists($twigFile)) {
            printf(
                "Configured twig cache file '%s' not found%s",
                $twigFile,
                PHP_EOL
            );
            exit(0);
        }
        if (false === unlink($twigFile)) {
            printf(
                "Error removing twig cache file '%s'%s",
                $twigFile,
                PHP_EOL
            );
            exit(1);
        }
        printf(
            "Removed configured twig cache file '%s'%s",
            $twigFile,
            PHP_EOL
        );
    }
    if (false === rmdir($twigFolder)) {
        printf(
            "Error removing twig cache folder '%s'%s",
            $twigFolder,
            PHP_EOL
        );
        exit(1);
    }

    printf(
        "Removed configured twig cache folder '%s'%s",
        $twigFolder,
        PHP_EOL
    );
}
exit(0);
