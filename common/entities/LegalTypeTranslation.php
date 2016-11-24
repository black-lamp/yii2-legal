<?php
namespace bl\legalAgreement\common\entities;

use yii\db\ActiveRecord;

use bl\seo\behaviors\SeoDataBehavior;

/**
 * This is the model class for table "legal_type_translation".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $language_id
 * @property string $title
 *
 * @property string $seoTitle
 * @property string $seoDescription
 * @property string $seoKeywords
 * @property string $seoUrl
 *
 * @property LegalType $type
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class LegalTypeTranslation extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'seoData' => [
                'class' => SeoDataBehavior::className()
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'legal_type_translation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'language_id', 'title'], 'required'],
            [['type_id', 'language_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [
                ['type_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => LegalType::className(),
                'targetAttribute' => ['type_id' => 'id']
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
            'type_id' => 'Type ID',
            'language_id' => 'Language ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(LegalType::className(), ['id' => 'type_id']);
    }
}
