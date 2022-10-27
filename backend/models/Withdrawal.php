<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "withdrawal".
 *
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property string $status
 * @property string $created_at
 *
 * @property User $user
 */
class Withdrawal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'withdrawal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'status'], 'required'],
            [['user_id'], 'integer'],
            [['amount'], 'number'],
            [['status'], 'string'],
            [['created_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Date Requested'),
        ];
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
     * @return WithdrawalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WithdrawalQuery(get_called_class());
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getTotalWithdrawal($id)
    {
        return  $this::find()->where(['user_id'=> $id])->sum('amount');
    }
}
