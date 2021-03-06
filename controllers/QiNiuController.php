<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;

/**
 * UserController implements the CRUD actions for User model.
 */
class QiNiuController extends Controller
{
    public $bucket = 'wechat';
    public $accessKey = 'ie3mImuh0rfrinPrtfUXqQHTJ_J5YylDrojwj-sx';
    public $secretKey = 'fn0VbpifXsV5m3DGUcNqGwgW8DyZht9d_YtJRe0u';

    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                //'only' => ['index','create',"update","submit","list","show","showDetail],
                'rules' => [
                    [
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ]
                ],
            ]
        ];
    }

    public function actionUpToken(){

        $encodedPutPolicy = $this->URLSafeBase64Encode($this->createReturnBody());

        //hmac_sha1这个函数没有，用其他函数实现
        //$sign=mhash(MHASH_SHA1,$encodedPutPolicy, $this->secretKey);
        $sign=hash_hmac('sha1', $encodedPutPolicy, $this->secretKey, true);

        $encodedSign =$this->URLSafeBase64Encode($sign);

        $uploadToken=$this->accessKey.":".$encodedSign.":".$encodedPutPolicy;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return array("uptoken"=>$uploadToken);
    }

    public function URLSafeBase64Encode($str) // URLSafeBase64Encode
    {
        $find = array('+', '/');
        $replace = array('-', '_');
        return str_replace($find, $replace, base64_encode($str));
    }

    public function URLSafeBase64Decode($str)
    {
        $find = array('-', '_');
        $replace = array('+', '/');
        return base64_decode(str_replace($find, $replace, $str));
    }

    /**
     * 创建uploadToken时需要返回的值
     * @return mixed|string|void
     */
    public function createReturnBody(){

        //使用专有通道
        $returnBody=array("scope"=>$this->bucket,"deadline"=>24*60*60+time());

        return json_encode($returnBody);
    }

}
