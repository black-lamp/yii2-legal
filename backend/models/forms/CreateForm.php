<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\backend\models\forms;

use yii\base\Exception;

use bl\legalAgreement\common\entities\Legal;
use bl\legalAgreement\common\entities\LegalTranslation;

/**
 * Model class for Create form
 *
 * @property integer $langId
 * @property string $key
 * @property string $text
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class CreateForm extends LegalForm
{
    /**
     * @inheritdoc
     * @throws Exception
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Legal::getDb()->beginTransaction();
        try {
            $legal = new Legal([
                'key' => $this->key
            ]);
            $legal->insert();

            (new LegalTranslation([
                'legal_id' => $legal->id,
                'language_id' => $this->langId,
                'text' => $this->text
            ]))
            ->insert(false);

            $transaction->commit();

            return true;
        }
        catch (Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
    }
}