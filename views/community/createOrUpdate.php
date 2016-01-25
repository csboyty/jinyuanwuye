<?php

use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = '新建/修改社区动态';
?>


<form class="form-horizontal" id="myForm" action="community/submit" method="post">
    <?php
        if($model->community_id){
            ?>
            <input type="hidden" name="community_id" value="<?php echo $model->community_id ?>">
            <?php
        }
    ?>
    <div class="form-group">
        <label for="name" class="control-label col-md-2">标题*</label>
        <div class="col-md-8">
            <input type="text" class="form-control" value="<?php echo $model->community_title ?>"
                   name="community_title">
        </div>
    </div>
    <div class="form-group">
        <label  class="control-label col-md-2">内容*</label>
        <div class="col-md-8">
            <textarea class="form-control"  name="community_content" rows="3" id="content"><?php echo $model->community_content ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <button type="submit" class="btn btn-success form-control">确定</button>
        </div>
    </div>
</form>

<?php
    $this->registerJsFile("@web/js/src/communityCreateOrUpdate.js",['depends' => [app\assets\AppAsset::className()]]);
?>