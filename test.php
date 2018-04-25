<?php

require('vendor/autoload.php');

use Ronanchilvers\Utility\Collection;

$c1 = new Collection([
    'one' => 'one',
    'two' => 'two',
    'three' => 'three'
]);
$c2 = new Collection([
    'one',
    'two',
    'three'
]);

// @TODO Remove var_dump
var_dump(
    $c1->first(),
    $c1->last(),
    $c1->at('two'),
    $c2->first(),
    $c2->last(),
    $c2->at(1)
); exit();
foreach ($collection as $item) {
    var_dump($item);
}
