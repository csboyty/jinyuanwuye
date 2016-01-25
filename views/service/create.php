<?php
use yii\helpers\Html;
use app\assets\userAsset;

$this->title = '报修提交';
?>
<form class="form-horizontal" id="myForm" action="service/submit" method="post">

    <div class="form-group">
        <label for="name" class="control-label col-md-2">内容*</label>
        <div class="col-md-8">
            <input type="text" class="form-control"
                   name="remark">
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="control-label col-md-2">地址*</label>
        <div class="col-md-8">
            <input type="text" class="form-control"
                   name="address">
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="control-label col-md-2">联系电话*</label>
        <div class="col-md-8">
            <input type="text" class="form-control"
                   name="tel">
        </div>
    </div>

    <div class="form-group">
    <div class="col-md-offset-2 col-md-8">
        <button type="submit" class="btn btn-success form-control">确定</button>
    </div>
</div>
</form>



<?php
$this->registerJsFile("@web/js/src/serviceCreate.js",['depends' => [app\assets\UserAsset::className()]]);
?>