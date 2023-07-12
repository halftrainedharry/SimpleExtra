<?php
/**
 * Sort two items.
 * This code is based on the code from the extra "FaqMan" (https://github.com/josht/faqMan),
 * which in turn uses code from the extra "Gallery" (https://github.com/splittingred/Gallery)
*/

namespace SimpleExtra\Processors\Item;

use MODX\Revolution\Processors\Model\UpdateProcessor;
use SimpleExtra\Model\Item;

class Sort extends UpdateProcessor
{
    public $classKey = Item::class;
    public $objectType = 'simpleextra.item';

    public function initialize()
    {
        $primaryKey = $this->getProperty('source', false);
        if (empty($primaryKey)) {
            return 'Source item not specified.';
        }
        $this->object = $this->modx->getObject($this->classKey, $primaryKey);
        if (empty($this->object)) {
            return 'Source item not found.';
        }

        return true;
    }

    public function process() {
        /* Run the beforeSet method before setting the fields, and allow stoppage */
        $canSave = $this->beforeSet();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }

        $source = $this->object;

        $target = $this->modx->getObject($this->classKey, [
            'id' => $this->getProperty('target'),
        ]);

        if (empty($target)) {
            return $this->failure('Target item not found.');
        }

        if ($source->get('position') < $target->get('position')) {
            $this->modx->exec("
                UPDATE {$this->modx->getTableName($this->classKey)}
                SET `position` = `position` - 1
                WHERE
                `position` <= {$target->get('position')}
                AND `position` > {$source->get('position')}
                AND `position` > 0
            ");
        } else {
            $this->modx->exec("
                UPDATE {$this->modx->getTableName($this->classKey)}
                SET `position` = `position` + 1
                WHERE
                `position` >= {$target->get('position')}
                AND `position` < {$source->get('position')}
            ");
        }
        $newPosition = $target->get('position');
        $source->set('position', $newPosition);
        $source->save();

        $this->afterSave();

        // Report source (dragged item) was changed
        $this->fireAfterSaveEvent();
        $this->logManagerAction();
        return $this->cleanup();
    }
}