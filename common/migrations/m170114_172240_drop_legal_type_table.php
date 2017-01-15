<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `legal_type`.
 */
class m170114_172240_drop_legal_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropForeignKey('legal_type-legal-FK', 'legal');

        $this->dropTable('legal_type');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('legal_type', [
            'id' => $this->primaryKey(),
            'position' => $this->integer()->notNull()
        ]);
    }
}
