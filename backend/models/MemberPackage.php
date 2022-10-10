<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "member_package".
 *
 * @property int $id
 * @property int $user_id
 * @property int $refferor_id
 * @property int $package_id
 * @property string $filling_date
 * @property string $status
 * @property string $create_at
 *
 * @property Packages $package
 * @property User $refferor
 * @property User $user
 */
class MemberPackage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member_package';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'refferor_id', 'package_id', 'filling_date', 'status'], 'required'],
            [['user_id', 'refferor_id', 'package_id'], 'integer'],
            [['filling_date', 'create_at'], 'safe'],
            [['status'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packages::class, 'targetAttribute' => ['package_id' => 'id']],
            [['refferor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['refferor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'refferor_id' => Yii::t('app', 'Refferor ID'),
            'package_id' => Yii::t('app', 'Package ID'),
            'filling_date' => Yii::t('app', 'Filling Date'),
            'status' => Yii::t('app', 'Status'),
            'create_at' => Yii::t('app', 'Create At'),
        ];
    }

    /**
     * Gets query for [[Package]].
     *
     * @return \yii\db\ActiveQuery|PackagesQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Packages::class, ['id' => 'package_id']);
    }

    /**
     * Gets query for [[Refferor]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getRefferor()
    {
        return $this->hasOne(User::class, ['id' => 'refferor_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return MemberPackageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemberPackageQuery(get_called_class());
    }
}
