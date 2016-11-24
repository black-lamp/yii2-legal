<?php
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
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
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
