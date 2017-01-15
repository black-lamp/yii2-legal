<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\common\entities;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "legal_user_tokens".
 *
 * @property integer $id
 * @property integer $legal_id
 * @property integer $user_id
 * @property string $token
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class LegalUserTokens extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'legal_user_tokens';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['legal_id', 'user_id', 'token'], 'required'],
            [['legal_id', 'user_id'], 'integer'],
            [['token'], 'string', 'max' => 64],
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
            'user_id' => 'User ID',
            'token' => 'Token',
        ];
    }
}
