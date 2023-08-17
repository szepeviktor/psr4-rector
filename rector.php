<?php

use Rector\Config\RectorConfig;
use SzepeViktor\Rector\Psr4\Psr4Rector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(Psr4Rector::class);
};
