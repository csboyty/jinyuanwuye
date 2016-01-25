<?php

namespace app\controllers;

use Yii;
use app\models\Notice;
use app\controllers\WeChatController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;

/**
 * NoticeController implements the CRUD actions for Notice model.
 */
class NoticeController extends WeChatController
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
                        'actions' => ['show',"show-detail"],
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            "?"
                        ],
                    ],
                    [
                        'actions' => ['index',"create","update","list","delete","submit"],
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 显示通知（用户）
     * @return string
     */
    public function actionShow(){
        $this->getOpenId();

        $this->layout="user";

        $query=Notice::find();
        $results=$query
            ->joinWith([
                "user"=>function($query){
                    $query->where(["enterprise_id"=>yii::$app->user->getIdentity()->enterprise_id]);
                    //$query->where(["enterprise_id"=>yii::$app->user->getIdentity()?0:1]);
                }
            ])
            ->orderBy([
                'notice_id' => SORT_DESC,
            ])
            ->asArray()
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


    public function actionList(){
        $params=Yii::$app->request->queryParams;
        $limit=$params["iDisplayLength"];
        $offset=$params["iDisplayStart"];
        $sEcho = $params["sEcho"];
        $query=Notice::find();
        $count=$query->count();
        $aaData=$query
            ->asArray()
            ->orderBy([
                'notice_id' => SORT_DESC,
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

        $model=new Notice();

        return $this->render('createOrUpdate',[
            'model' => $model,
        ]);
    }

    public function actionUpdate($id){

        //这样获取会将isNewRecord设置为false
        $model = $this->findModel($id);

        return $this->render('createOrUpdate',[
            'model' => $model,
        ]);
    }

    /**
     *新增和修改提交
     * @return array
     */
    public function actionSubmit(){
        $params=Yii::$app->request->post();

        if(isset($params["notice_id"])){
            $model = $this->findModel($params["notice_id"]);
        }else{
            $model=new Notice();
            $params["create_at"]=date("Y-m-d");
            $params["user_id"]=Yii::$app->user->getId();
        }



        $data=array();

        //yii自动生成的form参数是Enterprise["name"]这种形式，获取后就会是在一个Enterprise中
        $data["Notice"]=$params;

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
    /**
     * Finds the Notice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
