<?php
use yii\db\Migration;

/**
 * Handles the creation of table `legal_user`.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class m160928_163143_create_legal_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('legal_user', [
            'id' => $this->primaryKey(),
            'legal_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('legal-legal_user-FK', 'legal_user', 'legal_id', 'legal', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('legal-legal_user-FK', 'legal_user');

        $this->dropTable('legal_user');
    }
}
