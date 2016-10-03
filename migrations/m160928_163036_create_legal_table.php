<?php
use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160928_163036_create_legal_table extends Migration
{
    public function up()
    {
        $this->createTable('legal', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'version' => $this->integer()->notNull(),
            'show' => $this->boolean()->defaultValue(false)
        ]);

        $this->addForeignKey('legal_type-legal-FK', 'legal', 'type_id', 'legal_type', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('legal_type-legal-FK', 'legal');

        $this->dropTable('legal');
    }
}
