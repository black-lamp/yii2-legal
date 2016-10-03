<?php
namespace bl\legalAgreement\entities;

use Yii;

/**
 * This is the model class for table "legal_translation".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $legal_id
 * @property integer $language_id
 * @property string $text
 *
 * @property Legal $legal
 */
class LegalTranslation extends \yii\db\ActiveRecord
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
    public function rules()
    {
        return [
            [['legal_id', 'language_id', 'text'], 'required'],
            [['legal_id', 'language_id'], 'integer'],
            [['text'], 'string'],
            [
                ['legal_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Legal::className(),
                'targetAttribute' => ['legal_id' => 'id']
            ],
        ];
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
     * @return \yii\db\ActiveQuery
     */
    public function getLegal()
    {
        return $this->hasOne(Legal::className(), ['id' => 'legal_id']);
    }
}
