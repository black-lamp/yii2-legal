<?php
use yii\db\Migration;

/**
 * Handles the creation of table `legal`.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class m160928_163036_create_legal_table extends Migration
{
    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('legal_type-legal-FK', 'legal');

        $this->dropTable('legal');
    }
}
