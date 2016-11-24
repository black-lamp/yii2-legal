<?php
use yii\db\Migration;

/**
 * Handles the creation of table `legal_user_tokens`.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class m161122_205607_create_legal_user_tokens_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('legal_user_tokens', [
            'id' => $this->primaryKey(),
            'legal_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string(64)->notNull()
        ]);

        $this->addForeignKey('legal_user_token-legal-FK', 'legal_user_tokens', 'legal_id', 'legal', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('legal_user_token-legal-FK', 'legal_user_tokens');

        $this->dropTable('legal_user_tokens');
    }
}
