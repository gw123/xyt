<div class="stem"><h3>题干：</h3><? echo $question['stem'] ?> </div>

<?  if(empty($hideAnswer)) { ?>
    <div class="answer">
        <h3>答案：</h3>
        <?php  if($question['answer']==1){ echo "正确";} else{ echo "错误"; } ?>
    </div>
    <div class="analysis"><h3>分析：</h3><?= $question['analysis'] ?> </div>
<? } ?>

