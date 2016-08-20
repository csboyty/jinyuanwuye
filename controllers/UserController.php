<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Enterprise;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        //'actions' => ['index'],
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            User::ROLE_SUPER_ADMIN,
                        ],
                    ]
                ],
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList(){
        $params=Yii::$app->request->queryParams;
        $limit=$params["iDisplayLength"];
        $offset=$params["iDisplayStart"];
        $sEcho = $params["sEcho"];
        $query=User::find();
        $count=$query->count();
        $aaData=$query
            ->select(array('name','user_id','enterprise_id'))
            ->with("enterprise")
            ->asArray()
            ->limit($limit)
            ->offset($offset)
            ->all();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


        return [
            'success' => true,
            'aaData' => $aaData,
            "iTotalRecords"=>$count,
            "iTotalDisplayRecords"=>$count,
            "sEcho"=>$sEcho
        ];

    }

    public function actionCreate(){

        $model=new User();
        $enterprises=Enterprise::find()
            ->asArray()
            ->all();

        return $this->render('createOrUpdate',[
            "enterprises"=>$enterprises,
            'model' => $model,
        ]);
    }

    public function actionUpdate($id){

        //这样获取会将isNewRecord设置为false
        $model = $this->findModel($id);

        $enterprises=Enterprise::find()
            ->asArray()
            ->all();

        return $this->render('createOrUpdate',[
            "enterprises"=>$enterprises,
            'model' => $model,
        ]);
    }

    /**
     *新增和修改提交
     * @return array
     */
    public function actionSubmit(){
        $params=Yii::$app->request->post();

        if(isset($params["user_id"])){
            $model = $this->findModel($params["user_id"]);
        }else{
            $model=new User();
            $params["role"]=USER::ROLE_ADMIN;
            $model->generateAuthKey();
            $params["auth_key"]=$model->getAuthKey();

            //对密码加密
            $model->setPassword($params["password"]);
            $params["password"]=$model->getAttribute("password");
        }

        $data=array();

        //yii自动生成的form参数是Enterprise["name"]这种形式，获取后就会是在一个Enterprise中
        $data["User"]=$params;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($model->load($data) && $model->save()) {
            return [
                "success"=>true
            ];
        }else{
            return [
                "success"=>false,
                "error_code"=>1
            ];
        }
    }
    public function actionSetPassword(){
        $params=Yii::$app->request->post();
        $model = $this->findModel($params["user_id"]);

        //对密码加密
        $model->setPassword($params["password"]);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($model->save()) {
            return [
                "success"=>true
            ];
        }else{
            return [
                "success"=>false,
                "error_code"=>1
            ];
        }
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        //数据库建立了外键，如果删除用户，所有的相关数据都会删除
        /* if($this->findModel($id)->delete()){
            return [
                "success"=>true
            ];
        }else{
            return [
                "success"=>false,
                "error_code"=>1
            ];
        }*/

        return [
            "success"=>true
        ];

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
