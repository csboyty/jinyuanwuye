<?php
$this->title="通知详情";
?>

<p class="text-primary">日期：<?php echo $model->create_at; ?></p>
<p class="text-primary">标题：<?php echo $model->notice_name; ?></p>
<p class="text-primary">内容：<?php echo $model->notice_content; ?></p>