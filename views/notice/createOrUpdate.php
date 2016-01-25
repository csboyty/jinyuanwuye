<?php

use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = '新建/修改通知';
?>


<form class="form-horizontal" id="myForm" action="notice/submit" method="post">
    <?php
        if($model->notice_id){
            ?>
            <input type="hidden" name="notice_id" value="<?php echo $model->notice_id ?>">
            <?php
        }
    ?>
    <div class="form-group">
        <label for="name" class="control-label col-md-2">标题*</label>
        <div class="col-md-8">
            <input type="text" class="form-control" value="<?php echo $model->notice_name ?>" name="notice_name">
        </div>
    </div>
    <div class="form-group">
        <label  class="control-label col-md-2">内容*</label>
        <div class="col-md-8">
            <textarea class="form-control"  name="notice_content" rows="3" id="content"><?php echo $model->notice_content ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <button type="submit" class="btn btn-success form-control">确定</button>
        </div>
    </div>
</form>

<?php
    $this->registerJsFile("@web/js/src/noticeCreateOrUpdate.js",['depends' => [app\assets\AppAsset::className()]]);
?>