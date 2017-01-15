<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\common\entities;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "legal_translation".
 *
 * @property integer $id
 * @property integer $legal_id
 * @property integer $language_id
 * @property string $text
 *
 * @property Legal $legal
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class LegalTranslation extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'legal_translation';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'legal_id' => 'Legal ID',
            'language_id' => 'Language ID',
            'text' => 'Text',
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            'default' => self::OP_INSERT | self::OP_UPDATE
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegal()
    {
        return $this->hasOne(Legal::className(), ['id' => 'legal_id']);
    }
}
