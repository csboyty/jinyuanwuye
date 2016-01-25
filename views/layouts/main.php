<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <base href="http://localhost/jinyuanwuye/web/">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="header">
    <h1 class="logo">金园物业管家</h1>
    <a href="site/logout" class="logout">退出</a>
</div>

<div class="left">
    <ul class="menu">

        <?php
        if(isset(Yii::$app->user->identity)&&Yii::$app->user->identity->role=="SUPER_ADMIN"){
            ?>
            <li class="item">
                <span class="glyphicon glyphicon-flag"></span>
                <a class="link" href="enterprise/index">公司管理</a>
            </li>
            <li class="item">
                <span class="glyphicon glyphicon-flag"></span>
                <a class="link" href="user/index">用户管理</a>
            </li>
            <?php
        }else{
            ?>
            <li class="item">
                <span class="glyphicon glyphicon-flag"></span>
                <a class="link" href="notice/index">通知管理</a>
            </li>
            <li class="item">
                <span class="glyphicon glyphicon-flag"></span>
                <a class="link" href="community/index">社区动态管理</a>
            </li>
            <li class="item">
                <span class="glyphicon glyphicon-flag"></span>
                <a class="link" href="service/index">报修管理</a>
            </li>
            <?php
        }
        ?>
    </ul>
</div>

<div class="right">
    <div class="main">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>


<div class="loading hidden" id="loading">
    <span class="text">Loading...</span>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
