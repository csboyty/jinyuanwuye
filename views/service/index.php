<?php

use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = '报修管理';
?>


    <table id="myTable" class="dataTable">
        <thead>
        <tr>
            <th>姓名</th>
            <th>电话</th>
            <th>内容</th>
            <th>时间</th>
            <th>状态</th>
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
                    <h4 class="modal-title">报修详情</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="myForm" action="service/handle" method="post">
                        <input type="hidden" name="service_id" id="serviceId" value="">
                        <div class="form-group">
                            <label  class="control-label col-md-2">姓名*</label>
                            <div class="col-md-8">
                                <p id="name">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="control-label col-md-2">电话*</label>
                            <div class="col-md-8">
                                <p id="tel">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="control-label col-md-2">地址*</label>
                            <div class="col-md-8">
                                <p id="address">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="control-label col-md-2">内容*</label>
                            <div class="col-md-8">
                                <p id="remark">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="control-label col-md-2">状态*</label>
                            <div class="col-md-8">
                                <p id="status">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="control-label col-md-2">时间*</label>
                            <div class="col-md-8">
                                <p id="createDate">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="control-label col-md-2">处理时间*</label>
                            <div class="col-md-8">
                                <p id="handleDate">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="control-label col-md-2">处理安排*</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="feedback" id="feedback"></textarea>
                            </div>
                        </div>

                        <div class="form-group hidden" id="submitBtnRow">
                            <div class="col-md-offset-2 col-md-10">
                                <input type="submit" class="btn btn-success" value="处理">
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php
$this->registerJsFile("@web/js/src/serviceMgr.js",['depends' => [app\assets\AppAsset::className()]]);
?>