<?php

use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = '新建/修改用户';

?>

    <ul class="nav nav-tabs" id="myTabs">
        <li class="active"><a href="#info">基本信息</a></li>
        <?php
        if($model->user_id){
            ?>
        <li ><a href="#password">密码</a></li>
        <?php
        }
        ?>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="info" style="padding-top: 10px">
            <form class="form-horizontal" id="myForm" action="user/submit" method="post">
                <?php
                if($model->user_id){
                    ?>
                    <input type="hidden" name="user_id" value="<?php echo $model->user_id ?>">
                <?php
                }
                ?>
                <div class="form-group">
                    <label for="name" class="control-label col-md-2">姓名*</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $model->name ?>" name="name">
                    </div>
                </div>
                <?php
                if(!$model->user_id){
                    ?>
                    <div class="form-group">
                        <label  class="control-label col-md-2">密码*</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="password">
                        </div>
                    </div>
                <?php
                }
                ?>

                <div class="form-group">
                    <label for="name" class="control-label col-md-2">公司*</label>
                    <div class="col-md-8">
                        <select name="enterprise_id" class="form-control">
                            <?php
                            foreach($enterprises as $en){
                                ?>

                                <option
                                    <?php if($model->enterprise_id&&$model->enterprise_id==$en["enterprise_id"]){
                                        echo "selected";
                                    } ?>
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
        </div>

        <?php
        if($model->user_id){
        ?>
        <div role="tabpanel" class="tab-pane" id="password" style="padding-top: 10px">
            <form class="form-horizontal" id="myFormPWD" action="user/set-password" method="post">
                <input type="hidden" name="user_id" value="<?php echo $model->user_id ?>">
                <div class="form-group">
                    <label  class="control-label col-md-2">密码*</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <button type="submit" class="btn btn-success form-control">确定</button>
                    </div>
                </div>
            </form>
        </div>
        <?php
        }
        ?>

    </div>


<?php
    $this->registerJsFile("@web/js/src/userCreateOrUpdate.js",['depends' => [app\assets\AppAsset::className()]]);
?>