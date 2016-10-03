<?php
use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160928_163015_create_legal_type_table extends Migration
{
    public function up()
    {
        $this->createTable('legal_type', [
            'id' => $this->primaryKey(),
            'position' => $this->integer()->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('legal_type');
    }
}
