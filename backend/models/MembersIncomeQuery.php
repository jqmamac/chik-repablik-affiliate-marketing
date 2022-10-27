<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[MembersIncome]].
 *
 * @see MembersIncome
 */
class MembersIncomeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MembersIncome[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MembersIncome|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
