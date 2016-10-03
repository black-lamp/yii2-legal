<?php
namespace bl\legalAgreement\entities;

use Yii;
use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "legal_type".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $position
 *
 * @property Legal[] $legals
 * @property LegalTypeTranslation[] $legalTypeTranslations
 *
 * Behaviors
 * @method movePrev()
 * @method moveNext()
 */
class LegalType extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'position' => [
                'class' => PositionBehavior::className()
            ]
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'legal_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegals()
    {
        return $this->hasMany(Legal::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegalTypeTranslations()
    {
        return $this->hasMany(LegalTypeTranslation::className(), ['type_id' => 'id']);
    }
}
