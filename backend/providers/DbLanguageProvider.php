<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\backend\providers;

use Yii;
use yii\base\Object;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Database language provider
 *
 * @property string $arModel
 * @property integer $idField
 * @property string $nameField
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class DbLanguageProvider extends Object implements LanguageProviderInterface
{
    /**
     * @var string Id of database component from application config
     */
    public $db = 'db';
    /**
     * @var string Name of table in database
     */
    public $tableName = 'language';
    /**
     * @var string Name of field with primary key
     */
    public $idField = 'id';
    /**
     * @var string Name of field with language name
     */
    public $nameField = 'name';

    /**
     * @var ActiveRecord[]
     */
    protected $languages = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        $db = Yii::$app->get($this->db);

        /** @var ActiveRecord $entity */
        $languages = (new Query())
            ->select([$this->idField, $this->nameField])
            ->from($this->tableName)
            ->all($db);

        foreach ($languages as $language) {
            $this->languages[$language[$this->idField]] = $language[$this->nameField];
        }
    }

    /**
     * @inheritdoc
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @inheritdoc
     */
    public function getDefault()
    {
        return each($this->languages);
    }

    /**
     * @inheritdoc
     */
    public function getNameByID($id)
    {
        return ArrayHelper::getValue($this->languages, $id);
    }
}