<?php
namespace bl\legalAgreement\entities;

use Yii;

/**
 * This is the model class for table "legal_user".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $legal_id
 * @property integer $user_id
 *
 * @property Legal $legal
 */
class LegalUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'legal_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['legal_id', 'user_id'], 'required'],
            [['legal_id', 'user_id'], 'integer'],
            [
                ['legal_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Legal::className(),
                'targetAttribute' => ['legal_id' => 'id']],
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
            'user_id' => 'User ID',
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
