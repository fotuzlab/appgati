# AppGati

Based on the original [AppGati](https://github.com/fotuzlab/appgati), refactored to modern PHP.

## Installation
```console
$ composer require --dev subiabre/appgati
```

## Usage
AppGati allows you to easily gauge the performance of PHP script's.

```php
<?php

include 'vendor/autoload';

$app = new AppGati;

$app->step('start');

// some code...

$app->step('end');

$report = $app->getReport('start', 'end');

print_r($report);
```

Output:
```php
Array
(
    ['Clock time in seconds'] => 14.363237142563
    ['Time taken in User Mode in seconds'] => 0.676958
    ['Time taken in System Mode in seconds'] => 13.680072
    ['Total time taken in Kernel in seconds'] => 14.35703
    ['Memory limit in MB'] => -1
    ['Memory usage in MB'] => 0.002655029296875
    ['Peak memory usage in MB'] => 1.0958099365234
    ['Maximum resident shared size in KB'] => 0
    ['Integral shared memory size'] => 0
    ['Integral unshared data size'] => 0
    ['Integral unshared stack size'] => Not Available
    ['Number of page reclaims'] => 0
    ['Number of page faults'] => 0
    ['Number of block input operations'] => 0
    ['Number of block output operations'] => Not Available
    ['Number of messages sent'] => 0
    ['Number of messages received'] => 0
    ['Number of signals received'] => 0
    ['Number of voluntary context switches'] => 0
    ['Number of involuntary context switches'] => 1514
)
```

AppGati works by creating snapshots of time and system information in a given moment, known as *steps*, and then comparing two different steps. By using AppGati you can easily track your application performance in several different moments in an easy fashion, but it's still nothing short of an authentic benchmark tool such as Xdebug profiling capabilities.
