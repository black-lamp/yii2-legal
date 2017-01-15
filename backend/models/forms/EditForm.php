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
 * Model class for Edit form
 *
 * @property integer $legalId
 *
 * @property integer $langId
 * @property string $key
 * @property string $text
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class EditForm extends LegalForm
{
    /**
     * @var integer
     */
    public $legalId;

    /**
     * @var Legal
     */
    private $_legal;
    /**
     * @var LegalTranslation
     */
    private $_translation;


    /**
     * @inheritdoc
     * @param integer $legalId
     * @param integer $langId
     */
    public function __construct($legalId, $langId, $config = [])
    {
        $this->langId = $langId;
        $this->legalId = $legalId;

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->_legal = Legal::findOne($this->legalId);
        $this->_translation = LegalTranslation::findOne([
            'legal_id' => $this->_legal->id,
            'language_id' => $this->langId
        ]);

        $this->key = $this->_legal->key;
        if (!is_null($this->_translation)) {
            $this->text = $this->_translation->text;
        }
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_legal->key = $this->key;

        if (is_null($this->_translation)) {
            $this->_translation = new LegalTranslation([
                'legal_id' => $this->_legal->id,
                'language_id' => $this->langId
            ]);
        }

        $this->_translation->text = $this->text;

        $transaction = Legal::getDb()->beginTransaction();
        try {
            $this->_legal->update();
            $this->_translation->save(false);

            $transaction->commit();

            return true;
        }
        catch (Exception $ex) {
            $transaction->rollBack();
            throw  $ex;
        }
    }
}