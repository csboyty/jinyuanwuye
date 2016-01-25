<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "service".
 *
 * @property integer $service_id
 * @property integer $user_id
 * @property string $address
 * @property string $remark
 * @property integer $status
 * @property string $feedback
 * @property string $create_at
 * @property string $handle_at
 * @property string $tel
 *
 * @property User $user
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['create_at', 'handle_at'], 'safe'],
            [['address', 'remark', 'feedback'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_id' => 'Service ID',
            'user_id' => 'User ID',
            'address' => 'Address',
            'remark' => 'Remark',
            'status' => 'Status',
            'feedback' => 'Feedback',
            'create_at' => 'Create At',
            'handle_at' => 'Handle At',
            'tel' => 'Tel',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
}
