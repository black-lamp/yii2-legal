<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\backend\widgets;

use Yii;
use yii\base\Widget;

use bl\legalAgreement\backend\providers\LanguageProviderInterface;

/**
 * Widget for rendering list of languages
 *
 * @property integer $languageId
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class Language extends Widget
{
    /**
     * @var integer
     */
    public $languageId = null;


    /**
     * @inheritdoc
     */
    public function run()
    {
        /** @var LanguageProviderInterface $provider */
        $provider = Yii::$container->get(LanguageProviderInterface::class);

        $currentLanguage = (empty($this->languageId)) ?
            $provider->getDefault() :
            [$this->languageId => $provider->getNameByID($this->languageId)];

        return $this->render('languages', [
            'languages' => $provider->getLanguages(),
            'currentLanguage' => $currentLanguage
        ]);
    }
}
