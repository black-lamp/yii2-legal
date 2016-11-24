<?php
namespace bl\legalAgreement\common\entities;

use yii\db\ActiveRecord;

use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "legal_type".
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
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class LegalType extends ActiveRecord
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
