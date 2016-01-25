<?php

use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = '新建/修改公司';
?>


<form class="form-horizontal" id="myForm" action="enterprise/submit" method="post">
    <?php
        if($model->enterprise_id){
            ?>
            <input type="hidden" name="enterprise_id" value="<?php echo $model->enterprise_id ?>">
            <?php
        }
    ?>
    <div class="form-group">
        <label for="name" class="control-label col-md-2">名称*</label>
        <div class="col-md-8">
            <input type="text" class="form-control" value="<?php echo $model->enterprise_name ?>" name="enterprise_name">
        </div>
    </div>
    <div class="form-group">
        <label  class="control-label col-md-2">加入时间*</label>
        <div class="col-md-8">
            <input type="date" class="form-control" value="<?php echo $model->create_at ?>" name="create_at">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <button type="submit" class="btn btn-success form-control">确定</button>
        </div>
    </div>
</form>

<?php
    $this->registerJsFile("@web/js/src/enterpriseCreateOrUpdate.js",['depends' => [app\assets\AppAsset::className()]]);
?>