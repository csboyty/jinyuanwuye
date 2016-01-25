<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ty
 * Date: 15-12-29
 * Time: 下午5:30
 * To change this template use File | Settings | File Templates.
 */
namespace app\models;

use Yii;
use app\models\User;

class WeChatBindForm extends User{
    public $enterpriseId;
    public $weChatOpenId;
    public $name;

    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            [['name',"weChatOpenId"], 'required'],
            ['name', 'string', 'min' => 2, 'max' => 32],
            ['enterpriseId', 'required']
        ];
    }

    public function bindWeChat(){
        if ($this->validate()) {
            $user = new User();
            $user->name = $this->name;
            $user->wechat_open_id = $this->weChatOpenId;
            $user->enterprise_id=$this->enterpriseId;
            $user->generatePassword(8);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}