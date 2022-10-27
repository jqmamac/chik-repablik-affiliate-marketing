<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $address
 * @property string|null $birthdate
 * @property string $gender
 * @property string $mobile
 *
 * @property MemberPackage[] $memberPackages
 * @property MemberPackage[] $memberPackages0
 * @property MembersIncome[] $membersIncomes
 * @property Withdrawal[] $withdrawals
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'first_name', 'last_name', 'address', 'gender', 'mobile'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['birthdate'], 'safe'],
            [['gender'], 'string'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 225],
            [['mobile'], 'string', 'max' => 15],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'verification_token' => Yii::t('app', 'Verification Token'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'address' => Yii::t('app', 'Address'),
            'birthdate' => Yii::t('app', 'Birthdate'),
            'gender' => Yii::t('app', 'Gender'),
            'mobile' => Yii::t('app', 'Mobile'),
        ];
    }

    /**
     * Gets query for [[MemberPackages]].
     *
     * @return \yii\db\ActiveQuery|MemberPackageQuery
     */
    public function getMemberPackages()
    {
        return $this->hasMany(MemberPackage::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[MemberPackages0]].
     *
     * @return \yii\db\ActiveQuery|MemberPackageQuery
     */
    public function getMemberPackages0()
    {
        return $this->hasMany(MemberPackage::class, ['refferor_id' => 'id']);
    }

    /**
     * Gets query for [[MembersIncomes]].
     *
     * @return \yii\db\ActiveQuery|MembersIncomeQuery
     */
    public function getMembersIncomes()
    {
        return $this->hasMany(MembersIncome::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Withdrawals]].
     *
     * @return \yii\db\ActiveQuery|WithdrawalQuery
     */
    public function getWithdrawals()
    {
        return $this->hasMany(Withdrawal::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public function getStatusText()
    {

        switch ($this->status) {

        case 10:

            $text = "Active";

            break;

        case 9:

            $text = "Inactive";

            break;

        default:

            $text = "(Undefined)";

            break;

        }

        return $text;

    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getTotalIncome($id)
    {
        return  MembersIncome::find()->where(['user_id'=> $id])->sum('amount');
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
