<?php

use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = '通知管理';
?>


    <a class="btn btn-success" href="notice/create">
        <span class="glyphicon glyphicon-plus"></span> 新建
    </a>
    <table id="myTable" class="dataTable">
        <thead>
        <tr>
            <th>名称</th>
            <th>时间</th>
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

    <!--查看-->
    <div class="modal fade" id="checkModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">通知详情</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label  class="control-label col-md-2">标题*</label>
                            <div class="col-md-8">
                                <p id="name">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="control-label col-md-2">内容*</label>
                            <div class="col-md-8">
                                <p id="content">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php
$this->registerJsFile("@web/js/src/noticeMgr.js",['depends' => [app\assets\AppAsset::className()]]);
?>