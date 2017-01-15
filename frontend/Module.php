<?php
namespace bl\legalAgreement\frontend;

use Yii;

use bl\legalAgreement\common\components\LegalManager;

/**
 * Module for manipulation with legal agreements
 *
 * @property string $redirectRoute
 * @property string $flashMessage
 * @property string $messageKey
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'bl\legalAgreement\frontend\controllers';
    /**
     * @var string route for redirect in accept actions
     */
    public $redirectRoute = '/';
    /**
     * @var string message for user after agreement accepted
     */
    public $flashMessage = '';
    /**
     * @var string key for the flash message
     */
    public $messageKey = 'legal-agreement';
    /**
     * @var array configuration for LegalManager component
     */
    public $legalManagerComponent = [
        'class' => LegalManager::class
    ];


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->components = [
            'legalManager' => $this->legalManagerComponent
        ];
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
        return Yii::t('legal.' . $category, $message, $params, $language);
    }
}