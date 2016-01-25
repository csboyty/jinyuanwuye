<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use app\models\Community;
use app\controllers\WeChatController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EnterpriseController implements the CRUD actions for Enterprise model.
 */
class CommunityController extends WeChatController
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
     * Lists all Enterprise models.
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

        $query=Community::find();
        $results=$query
            ->joinWith([
                "user"=>function($query){
                    $query->where(["enterprise_id"=>yii::$app->user->getIdentity()->enterprise_id]);
                    //$query->where(["enterprise_id"=>yii::$app->user->getIdentity()?0:1]);
                }
            ])
            ->orderBy([
                'community_id' => SORT_DESC,
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
        $query=Community::find();
        $count=$query->count();
        $aaData=$query
            ->asArray()
            ->orderBy([
                'community_id' => SORT_DESC,
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
        $model=new Community();
        return $this->render('createOrUpdate',[
            'model' => $model,
        ]);
    }

    public function actionUpdate($id){

        //这样获取会将isNewRecord设置为false
        $model = $this->findModel($id);

        return $this->render('createOrUpdate', [
            'model' => $model,
        ]);
    }

    /**
     *新增和修改提交
     * @return array
     */
    public function actionSubmit(){
        $params=Yii::$app->request->post();

        if(isset($params["community_id"])){
            $model = $this->findModel($params["community_id"]);
        }else{
            $model=new Community();
            $params["create_at"]=date("Y-m-d");
            $params["user_id"]=Yii::$app->user->getId();
        }


        $data=array();

        //yii自动生成的form参数是Enterprise["name"]这种形式，获取后就会是在一个Enterprise中
        $data["Community"]=$params;

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
        if (($model = Community::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
