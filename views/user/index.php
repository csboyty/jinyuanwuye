<?php

use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = '用户管理';
?>


<a class="btn btn-success" href="user/create">
    <span class="glyphicon glyphicon-plus"></span> 新建
</a>
<table id="myTable" class="dataTable">
    <thead>
    <tr>
        <th>姓名</th>
        <th>公司</th>
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
    $this->registerJsFile("@web/js/src/userMgr.js",['depends' => [app\assets\AppAsset::className()]]);
?>