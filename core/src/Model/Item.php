<?php
namespace SimpleExtra\Model;

use xPDO\xPDO;

/**
 * Class Item
 *
 * @property string $name
 * @property string $description
 * @property integer $position
 *
 * @package SimpleExtra\Model
 */
class Item extends \xPDO\Om\xPDOSimpleObject
{
    public function save($cacheFlag = null) {
        // Set the field 'position', if it's not set yet and it's a new object
        if (empty($this->position) && $this->isNew()) {
            $items_count = $this->xpdo->getCount(self::class);
            $this->set('position', $items_count);
        }

        return parent::save($cacheFlag);
    }

    public function remove(array $ancestors = array ()) {
        $success = parent::remove($ancestors);

        if ($success) {
            // If the item was successfully deleted, decrease the position by 1 for every item with a position larger than the deleted item.
            $this->xpdo->exec("
                UPDATE {$this->xpdo->getTableName(self::class)}
                SET `position` = `position` - 1
                WHERE
                `position` > {$this->position}
                AND `position` > 0
            ");

        }
        return $success;
    }
}
