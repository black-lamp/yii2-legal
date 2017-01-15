<?php

use yii\db\Migration;

/**
 * Handles adding key to table `legal`.
 */
class m170114_172915_add_key_column_to_legal_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('legal', 'key', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('legal', 'key');
    }
}
