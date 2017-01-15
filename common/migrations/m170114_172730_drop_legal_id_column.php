<?php

use yii\db\Migration;

class m170114_172730_drop_legal_id_column extends Migration
{
    public function up()
    {
        $this->dropColumn('legal', 'type_id');
    }

    public function down()
    {
        echo "m170114_172730_drop_legal_id_column cannot be reverted.\n";

        return false;
    }
}
