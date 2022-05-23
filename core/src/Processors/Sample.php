<?php

namespace SimpleExtra\Processors;

use MODX\Revolution\Processors\Processor;
use SimpleExtra\Model\Item;

class Sample extends Processor
{
    public function process()
    {
        $count = $this->modx->getCount(Item::class);
        return $this->success('items count: ' . $count);

        /* Alternative way | Return a custom JSON structure */
        // $output = json_encode([
        //     'success' => true,
        //     'total' => $count,
        //     'message' => 'items count: ' . $count
        // ], JSON_INVALID_UTF8_SUBSTITUTE);
        // return $output;

        /* return an error */
        //return $this->failure('items count: ' . $count);
    }
}