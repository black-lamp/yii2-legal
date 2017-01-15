<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\backend;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Module for adding the legal agreements on site
 *
 * @property array $languageProvider
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'bl\legalAgreement\backend\controllers';
    /**
     * @var array language provider config
     * Example
     * ```php
     * 'languageProvider' => [
     *      'class' => bl\legalAgreement\backend\providers\DbLanguageProvider::class,
     *      'tableName' => 'language',
     *      'idField' => 'id',
     *      'nameField' => 'name'
     * ]
     * ```
     */
    public $languageProvider;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerDependencies();
    }

    /**
     * Add language provider to DI container
     */
    public function registerDependencies()
    {
        if(empty($this->languageProvider)) {
            throw new InvalidConfigException("Invalid configuration of '$this->id' module");
        }

        Yii::$container->set('bl\legalAgreement\backend\providers\LanguageProviderInterface', $this->languageProvider);
    }

    /**
     * Wrapper for default method `Yii::t()`
     *
     * @param string $category
     * @param string $message
     * @param array $params
     * @param null $language
     * @return string returns result of `Yii::t()` method
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('legal.backend.' . $category, $message, $params, $language);
    }
}
