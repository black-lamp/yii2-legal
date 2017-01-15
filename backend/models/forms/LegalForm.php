<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\backend\models\forms;

use yii\base\Model;

/**
 * Base model class for Create and Edit forms
 *
 * @property integer $langId
 * @property string $key
 * @property string $text
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
abstract class LegalForm extends Model
{
    /**
     * @var integer
     */
    public $langId;
    /**
     * @var string
     */
    public $key;
    /**
     * @var string
     */
    public $text;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['langId'], 'required'],
            [['langId'], 'integer'],

            [['key'], 'string', 'max' => 255],

            [['text'], 'required'],
            [['text'], 'string'],
        ];
    }

    /**
     * Method for saving data from form to database
     *
     * @return boolean
     */
    abstract public function save();
}