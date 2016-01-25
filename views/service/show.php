<?php
$this->title="报修";
?>

<a class="btn btn-success" style="margin-bottom: 15px;" href="service/create">
    <span class="glyphicon glyphicon-plus"></span> 新建
</a>
<div class="list-group">
    <?php
        foreach($results as $r){
            ?>

            <a href="service/show-detail?id=<?php echo $r["service_id"];?>"
               class="list-group-item"><?php echo $r["remark"];?>
                <?php if($r["status"]==2){
                    echo "(已处理)";
                }?>
            </a>

    <?php
        }
    ?>

</div>
