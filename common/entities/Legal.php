<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\common\entities;

use yii\db\ActiveRecord;

use bl\legalAgreement\common\db\LegalQuery;

/**
 * This is the model class for table "legal".
 *
 * @property integer $id
 * @property integer $version
 * @property integer $show
 * @property string $key
 *
 * @property LegalTranslation[] $legalTranslations
 * @property LegalTranslation $translation
 * @property LegalUser[] $legalUsers
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
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
            [['version'], 'safe'],
            [['show'], 'boolean'],
            [['show'], 'default', 'value' => false],
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
            'key' => 'Key'
        ];
    }

    /**
     * Method for generation the version for legal agreement
     *
     * @return integer
     */
    protected function generateVersion()
    {
        $version = Legal::find()
            ->where(['key' => $this->key])
            ->max('version');

        return ($version == null) ? 1 : ++$version;
    }

    /**
     * @inheritdoc
     */
    public function insert($runValidation = true, $attributes = null)
    {
        $this->version = self::generateVersion();
        return parent::insert($runValidation, $attributes);
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
     * @inheritdoc
     * @return LegalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LegalQuery(get_called_class());
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
