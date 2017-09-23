<div class="stem"><span class="q_sub_index"> <?=$question['position']?></span>， <? echo $question['stem'] ?> </div>

<?  if(empty($hideAnswer)) { ?>
    <div class="answer">
        <h3>答案：</h3>
        <?php  if($question['answer']==1){ echo "正确";} else{ echo "错误"; } ?>
    </div>
    <div class="analysis"><h3>分析：</h3><?= $question['analysis'] ?> </div>
<? } ?>

