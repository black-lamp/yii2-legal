<?php
use yii\db\Migration;

/**
 * Handles the creation of table `legal_type_translation`.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class m160928_163027_create_legal_type_translation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
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

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('legal_type-legal_type_translation-FK', 'legal_type_translation');

        $this->dropTable('legal_type_translation');
    }
}
