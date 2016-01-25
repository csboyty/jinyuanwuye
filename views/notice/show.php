<?php
$this->title="通知";
?>


<div class="list-group">
    <?php
    foreach($results as $r){
        ?>

        <a href="notice/show-detail?id=<?php echo $r["notice_id"];?>"
           class="list-group-item"><?php echo $r["notice_name"]."---".$r["create_at"];?></a>

    <?php
    }
    ?>

</div>
