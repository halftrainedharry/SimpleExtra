<?php

/*
// Snippet call
[[!getItems]]
*/

$items = $modx->getCollection('SimpleExtra\\Model\\Item');

$output = [];
foreach ($items as $item) {
    $item_array = $item->toArray();
    $output[] = json_encode($item_array);
}
return implode("<br>", $output);

//-------------------------------------------------

use SimpleExtra\Model\Item;

$items = $modx->getCollection(Item::class);

$output = [];
foreach ($items as $item) {
    $item_array = $item->toArray();
    $output[] = json_encode($item_array);
}
return implode("<br>", $output);

//-------------------------------------------------

/*
// Chunk "tplItem"
<h3>[[+name]] ([[+id]])</h3>
<p>[[+description]]</p>
*/

use SimpleExtra\Model\Item;

$items = $modx->getCollection(Item::class);

$output = [];
foreach ($items as $item) {
    $item_array = $item->toArray();
    $output[] = $modx->getChunk('tplItem', $item_array);
}
return implode("\n", $output);

//-------------------------------------------------

use SimpleExtra\Model\Item;

$c = $modx->newQuery(Item::class);
$c->sortby('name', 'DESC');
$items = $modx->getCollection(Item::class, $c);

$output = [];
foreach ($items as $item) {
    $item_array = $item->toArray();
    $output[] = $modx->getChunk('tplItem', $item_array);
}
return implode("\n", $output);

//-------------------------------------------------

/*
// Snippet calls
[[!getItems? &sortby=`id` &sortdir=`DESC`]]
<hr>
[[!getItems? &sortby=`name` &sortdir=`ASC`]]
*/

use SimpleExtra\Model\Item;

$tpl = $modx->getOption('tpl', $scriptProperties, 'tplItem');
$sortby = $modx->getOption('sortby', $scriptProperties, 'name');
$sortdir = $modx->getOption('sortdir', $scriptProperties, 'ASC');

$c = $modx->newQuery(Item::class);
$c->sortby($sortby, $sortdir);
$items = $modx->getCollection(Item::class, $c);

$output = [];
foreach ($items as $item) {
    $item_array = $item->toArray();
    $output[] = $modx->getChunk($tpl, $item_array);
}
return implode("\n", $output);