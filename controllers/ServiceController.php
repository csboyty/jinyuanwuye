<?php

namespace app\controllers;

use Yii;
use app\models\Service;
use app\controllers\WeChatController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;

/**
 * EnterpriseController implements the CRUD actions for Enterprise model.
 */
class ServiceController extends WeChatController
{

    public $layout="main";

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
                //'only' => ['index','create',"update","submit","list","show","showDetail],
                'rules' => [
                    [
                        'actions' => ['show',"show-detail","create","submit","delete"],
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            "?"
                        ],
                    ],
                    [
                        'actions' => ['index',"handle","list"],
                        'allow' => true,
                        // Allow moderators and admins to update
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ]
                ],
            ]
        ];
    }

    /**
     * Lists all Enterprise models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 显示用户的报修
     * @return string
     */
    public function actionShow(){
        $this->getOpenId();

        $this->layout="user";

        $query=Service::find();
        $results=$query
            ->where(['user_id' => Yii::$app->user->getId()])
            ->asArray()
            ->orderBy([
                'service_id' => SORT_DESC,
            ])
            ->all();


        return $this->render("show",[
            "results"=>$results
        ]);
    }
    public function actionShowDetail($id){

        $this->layout="user";

        $model=$this->findModel($id);
        return $this->render("showDetail",[
            "model"=>$model
        ]);
    }

    /**
     *处理提交
     * @return array
     */
    public function actionHandle(){
        $params=Yii::$app->request->post();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model=$this->findModel($params["service_id"]);
        $model->feedback=$params["feedback"];
        $model->status=2;
        $model->handle_at=date("Y-m-d");

        if ($model->update()) {
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

    public function actionList(){
        $params=Yii::$app->request->queryParams;
        $limit=$params["iDisplayLength"];
        $offset=$params["iDisplayStart"];
        $sEcho = $params["sEcho"];
        $query=Service::find();
        $count=$query->count();
        $aaData=$query
            ->with([
                "user"=>function($query){
                    $query->addSelect(["user_id","name"]);
                }
            ])
            ->asArray()
            ->orderBy([
                'service_id' => SORT_DESC,
            ])
            ->limit($limit)
            ->offset($offset)
            ->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => true,
            'aaData' => $aaData,
            "iTotalRecords"=>$count,
            "iTotalDisplayRecords"=>$count,
            "sEcho"=>$sEcho
        ];

    }

    public function actionCreate(){

        $this->getOpenId();

        $this->layout="user";

        $model=new Service();
        return $this->render('create',[
            'model' => $model,
        ]);
    }

    /**
     *新增和修改提交
     * @return array
     */
    public function actionSubmit(){
        $params=Yii::$app->request->post();

        $model=new Service();
        $params["create_at"]=date("Y-m-d");
        $params["user_id"]=Yii::$app->user->getId();
        $params["status"]=0;


        $data=array();

        //yii自动生成的form参数是Enterprise["name"]这种形式，获取后就会是在一个Enterprise中
        $data["Service"]=$params;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

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

    /**
     *由于建立了数据库的外键，这里删除后，所有相关的数据都将删除
     * @param $id
     * @return array
     */
    public function actionDelete($id)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($this->findModel($id)->delete()){
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

    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
