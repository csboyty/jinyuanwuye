<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\WeChatBindForm;
use app\models\Enterprise;

class WeChatController extends Controller{
    public $layout="user";
    public $appId="wx95ce83f1da61f3d0";
    public $secret="2d4591b9e34b46b1fac0f507a71b75c2";

    public function getOpenId(){
        if(!isset($_GET["code"])){
            return ;
        }
        $code = $_GET['code'];//获取code
        $weChat =  file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?".
        "appid=".$this->appId."&secret=".$this->secret."&code=".$code."&grant_type=authorization_code");
        $json = json_decode($weChat);

        if(!isset($json->openid)){
            return;
        }

        $user=User::findUserByWeChat($json->openid);
        if(!$user){
            $this->redirect(["we-chat/bind?weChatOpenId=".$json->openid]);
        }else{
            if(!Yii::$app->user->getId()){
                Yii::$app->getUser()->login($user,3600*24*30);
            }
        }
    }

    public function actionBind()
    {
        $weChatOpenId=Yii::$app->request->get("weChatOpenId");

        $model = new WeChatBindForm();

        $params=Yii::$app->request->post();


        $data=array();

        //yii自动生成的form参数是Enterprise["name"]这种形式，获取后就会是在一个Enterprise中
        $data["WeChatBindForm"]=$params;

        if ($model->load($data)) {
            if ($user = $model->bindWeChat()) {

                //自动登陆
                if (Yii::$app->getUser()->login($user)) {
                    $this->redirect(["notice/show"]);
                }
            }
        }

        $enterprises=Enterprise::find()
            ->asArray()
            ->all();

        $model->weChatOpenId=$weChatOpenId;
        return $this->render('weChatBind', [
            "enterprises"=>$enterprises,
            "model"=>$model
        ]);
    }
}