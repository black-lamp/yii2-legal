<?php
use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160928_163045_create_legal_translation_table extends Migration
{
    public function up()
    {
        $this->createTable('legal_translation', [
            'id' => $this->primaryKey(),
            'legal_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'text' => $this->text()->notNull()
        ]);

        $this->addForeignKey('legal-legal_translation-FK', 'legal_translation', 'legal_id',
            'legal', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('legal-legal_translation-FK', 'legal_translation');

        $this->dropTable('legal_translation');
    }
}