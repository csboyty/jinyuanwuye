<?php

$this->title = '绑定账号';
?>
<form class="form-horizontal" id="myForm" action="we-chat/bind" method="post">
    <input type="hidden" name="weChatOpenId" value="<?php echo $model->weChatOpenId ?>">
    <div class="form-group">
        <label for="name" class="control-label col-md-2">姓名*</label>
        <div class="col-md-8">
            <input type="text" class="form-control"
                   name="name">
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="control-label col-md-2">社区*</label>
        <div class="col-md-8">
            <select name="enterpriseId" class="form-control">
                <?php
                foreach($enterprises as $en){
                    ?>

                    <option
                        value="<?php echo $en["enterprise_id"]; ?>"><?php echo $en["enterprise_name"]; ?>
                    </option>

                <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <button type="submit" class="btn btn-success form-control">确定</button>
        </div>
    </div>
</form>
