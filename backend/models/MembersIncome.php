<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "members_income".
 *
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property string $type
 * @property string $created_at
 *
 * @property User $user
 */
class MembersIncome extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'members_income';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'type'], 'required'],
            [['user_id'], 'integer'],
            [['amount'], 'number'],
            [['type'], 'string'],
            [['note'], 'string'],
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
            'type' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
            'note' => Yii::t('app', 'Note'),
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
     * @return MembersIncomeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MembersIncomeQuery(get_called_class());
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getTotalIncome($id)
    {
        return  $this::find()->where(['user_id'=> $id])->sum('amount');
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getTotalIncomeOnly($id)
    {
        return  MembersIncome::find()->where(['user_id'=> $id,'type'=>'income'])->sum('amount');
    }
    
}
