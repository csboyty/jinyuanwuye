<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "community".
 *
 * @property integer $community_id
 * @property integer $user_id
 * @property string $community_title
 * @property string $create_at
 * @property string $community_content
 *
 * @property User $user
 */
class Community extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'community';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['create_at'], 'safe'],
            [['community_content'], 'string'],
            [['community_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'community_id' => 'Community ID',
            'user_id' => 'User ID',
            'community_title' => 'Community Title',
            'create_at' => 'Create At',
            'community_content' => 'Community Content',
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
