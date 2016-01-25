<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notice".
 *
 * @property integer $notice_id
 * @property string $enterprise_id
 * @property string $notice_name
 * @property string $create_time
 * @property string $notice_content
 * @property integer $user_id
 */
class Notice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notice_name','notice_content'],"required"],
            [['create_at'], 'safe'],
            [['notice_content',"notice_name"], 'string'],
            [['user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notice_id' => 'Notice ID',
            'notice_name' => 'Notice Name',
            'create_at' => 'Create Time',
            'notice_content' => 'Notice Content',
            'user_id' => 'User ID',
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
