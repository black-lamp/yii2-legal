<?php
use yii\db\Migration;

/**
 * Handles the creation of table `legal_translation.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class m160928_163045_create_legal_translation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $type = ($this->getDb()->getDriverName() == 'mysql') ?
            $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext') :
            $this->text();

        $this->createTable('legal_translation', [
            'id' => $this->primaryKey(),
            'legal_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'text' => $type
        ]);

        $this->addForeignKey('legal-legal_translation-FK', 'legal_translation', 'legal_id',
            'legal', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('legal-legal_translation-FK', 'legal_translation');

        $this->dropTable('legal_translation');
    }
}
