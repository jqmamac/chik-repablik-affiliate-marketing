<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "packages".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property float $daily_share
 * @property float $selling_period
 * @property float $weekly_withdrawal
 * @property string $create_at
 *
 * @property MemberPackage[] $memberPackages
 */
class Packages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'packages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'daily_share', 'selling_period', 'weekly_withdrawal'], 'required'],
            [['price', 'daily_share', 'selling_period', 'weekly_withdrawal'], 'number'],
            [['create_at'], 'safe'],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'daily_share' => Yii::t('app', 'Daily Share'),
            'selling_period' => Yii::t('app', 'Selling Period'),
            'weekly_withdrawal' => Yii::t('app', 'Weekly Withdrawal'),
            'create_at' => Yii::t('app', 'Create At'),
        ];
    }

    /**
     * Gets query for [[MemberPackages]].
     *
     * @return \yii\db\ActiveQuery|MemberPackageQuery
     */
    public function getMemberPackages()
    {
        return $this->hasMany(MemberPackage::class, ['package_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PackagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PackagesQuery(get_called_class());
    }

        /**
     * Gets query for [[MemberPackages]].
     *
     * @return \yii\db\ActiveQuery|MemberPackageQuery
     */
    public function getMemberPackagesName($id)
    {
        return ;
    }
    
}
