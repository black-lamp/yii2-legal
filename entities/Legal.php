<?php
namespace bl\legalAgreement\entities;

use Yii;

/**
 * This is the model class for table "legal".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $version
 * @property integer $show
 *
 * @property LegalType $type
 * @property LegalTranslation[] $legalTranslations
 * @property LegalUser[] $legalUsers
 */
class Legal extends \yii\db\ActiveRecord
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
    public function getLegalUsers()
    {
        return $this->hasMany(LegalUser::className(), ['legal_id' => 'id']);
    }
}
