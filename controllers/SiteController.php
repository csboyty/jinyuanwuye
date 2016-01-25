<?php

namespace app\controllers;

use Yii;
use app\models\LoginForm;
use app\models\User;

class SiteController extends \yii\web\Controller
{
    public $layout = false;

    public function actionLogin()
    {
        $this->layout="login";

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(["account/home"]);
        }

        $model = new LoginForm();

        $params=Yii::$app->request->post();

        $data=array();
        $data["LoginForm"]=$params;

        if ($model->load($data) && $model->login()) {
            return $this->redirect(["account/home"]);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout(){
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }

    public function actionError(){
        return $this->render("error");
    }

    public function actionHandle(){
        return $this->render("handle");
    }
}
