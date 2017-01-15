<?php
namespace bl\legalAgreement\common\db;

use yii\db\ActiveQuery;

/**
 * Query class for [[\bl\legalAgreement\common\entities\Legal]] model
 * 
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class LegalQuery extends ActiveQuery
{
    /**
     * Getting legal agreement translation by language ID
     *
     * @param integer $languageId
     * @return $this
     */
    public function withTranslation($languageId)
    {
        return $this->with([
            'translation' => function ($query) use ($languageId) {
                /** @var ActiveQuery $query */
                $query->andWhere(['language_id' => $languageId]);
            }
        ]);
    }
}