<?php

use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = '公司管理';
?>


<a class="btn btn-success" href="enterprise/create">
    <span class="glyphicon glyphicon-plus"></span> 新建
</a>
<table id="myTable" class="dataTable">
    <thead>
    <tr>
        <th>名称</th>
        <th>加入时间</th>
        <th>管理员</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <!--<tr>
        <td>分类1</td>
        <td>分类0</td>
        <td><a href="templates/backend/proCategoryUpdate.html">修改</a></td>
    </tr>-->
    </tbody>
</table>

<?php
    $this->registerJsFile("@web/js/src/enterpriseMgr.js",['depends' => [app\assets\AppAsset::className()]]);
?>