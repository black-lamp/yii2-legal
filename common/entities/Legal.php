<?php
namespace bl\legalAgreement\common\entities;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "legal".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $version
 * @property integer $show
 *
 * @property LegalType $type
 * @property LegalTranslation[] $legalTranslations
 * @property LegalTranslation $translation
 * @property LegalUser[] $legalUsers
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class Legal extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'legal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'version'], 'required'],
            [['type_id', 'version'], 'integer'],
            [['show'], 'boolean'],
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
            'version' => 'Version',
            'show' => 'Show',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(LegalType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegalTranslations()
    {
        return $this->hasMany(LegalTranslation::className(), ['legal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        return $this->hasOne(LegalTranslation::className(), ['legal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegalUsers()
    {
        return $this->hasMany(LegalUser::className(), ['legal_id' => 'id']);
    }
}
