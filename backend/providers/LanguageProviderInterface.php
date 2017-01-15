<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\backend\providers;

/**
 * Interface for language provider
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
interface LanguageProviderInterface
{
    /**
     * @return array where key it's a primary key and value it's language name
     *
     * Example
     * ```php
     * ['1' => 'English', '2' => 'Russian', ...]
     * ```
     */
    public function getLanguages();

    /**
     * @return array with default language
     *
     * Example
     * ```php
     * ['1' => 'English']
     * ```
     */
    public function getDefault();

    /**
     * @param integer $id ID of the language
     * @return string name of the language
     */
    public function getNameByID($id);
}