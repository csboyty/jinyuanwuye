<?php
$this->title="报修详情";
?>

<p class="text-primary">日期：<?php echo $model->create_at; ?></p>
<p class="text-primary">地址：<?php echo $model->address; ?></p>
<p class="text-primary">电话：<?php echo $model->tel; ?></p>
<p class="text-primary">状态：<?php
    $string="未处理";
    switch($model->status){
        case 0:
            $string="未处理";
            break;
        case 1:
            $string="处理中";
            break;
        case 2:
            $string="处理完成";
            break;
    }

    echo $string;

    ?></p>
<p class="text-primary">内容：<?php echo $model->remark; ?></p>
<p class="text-primary">处理日期：<?php echo $model->handle_at; ?></p>
<p class="text-primary">处理安排：<?php echo $model->feedback; ?></p>