<div class="text-center">
    <p>
        <?php if(isset($errorMessage)):?>
            <span class="glyphicon glyphicon-remove-sign text-danger"></span>
            <span class="btn-lg text-danger"><?php echo '操作出错啦！' ?></span>
            <?php echo '<p>'.$errorMessage.'</p>';?>
        <?php else:?>
            <span class="glyphicon glyphicon-ok-sign text-success"></span>
            <span class="btn-lg text-success">恭喜！操作成功！</span>
        <?php endif;?>
    </p>

    <p class="text-muted">该页将在3秒后自动跳转!</p>
    <p>
        <?php if(isset($gotoUrl)):?>
            <a href="<?php echo $gotoUrl?>">立即跳转</a>
        <?php else:?>
            <a href="javascript:void(0)"click="history.go(-1)">返回上一页</a>
        <?php endif;?>
    </p>
</div>