<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[MemberPackage]].
 *
 * @see MemberPackage
 */
class MemberPackageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MemberPackage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MemberPackage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
