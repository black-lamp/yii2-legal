<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `legal_type_translation`.
 */
class m170114_172223_drop_legal_type_translation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropForeignKey('legal_type-legal_type_translation-FK', 'legal_type_translation');

        $this->dropTable('legal_type_translation');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('legal_type_translation', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull()
        ]);

        $this->addForeignKey('legal_type-legal_type_translation-FK', 'legal_type_translation',
            'type_id', 'legal_type', 'id', 'CASCADE', 'CASCADE');
    }
}
