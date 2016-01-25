<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\User;


/**
 * This is the model class for table "enterprise".
 *
 * @property integer $enterprise_id
 * @property string $enterprise_name
 * @property string $create_time
 */
class Enterprise extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'enterprise';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enterprise_name','create_at'], 'required'],
            [['create_at'], 'safe'],
            [['enterprise_name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'enterprise_id' => '公司ID',
            'enterprise_name' => '公司名称',
            'create_at' => '创建时间',
        ];
    }

    /**
     *和user关联
     * @return ActiveQuery
     */
    public function getAdmin(){
        return $this->hasOne(User::className(), ['enterprise_id' => 'enterprise_id'])
            ->onCondition(['role' => "ADMIN"]);

    }

}
