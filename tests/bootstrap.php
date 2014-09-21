<?php
$vendorDir = findParentPath('vendor');

if (file_exists($file = $vendorDir . '/autoload.php')) {
    require_once $file;
} else {
    throw new \RuntimeException("Composer autoload not found");
}

function findParentPath($path)
{
    $dir = __DIR__;
    $previousDir = '.';
    while (!is_dir($dir . '/' . $path)) {
        $dir = dirname($dir);
        if ($previousDir === $dir) {
            return false;
        }
        $previousDir = $dir;
    }
    return $dir . '/' . $path;
}
