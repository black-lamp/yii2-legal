<?php
use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160928_163143_create_legal_user_table extends Migration
{
    public function up()
    {
        $this->createTable('legal_user', [
            'id' => $this->primaryKey(),
            'legal_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('legal-legal_user-FK', 'legal_user', 'legal_id', 'legal', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('legal-legal_user-FK', 'legal_user');

        $this->dropTable('legal_user');
    }
}
