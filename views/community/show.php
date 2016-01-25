<?php
$this->title="社区动态";
?>


<div class="list-group">
    <?php
    foreach($results as $r){
        ?>

        <a href="community/show-detail?id=<?php echo $r["community_id"];?>"
           class="list-group-item"><?php echo $r["community_title"];?></a>

    <?php
    }
    ?>

</div>
