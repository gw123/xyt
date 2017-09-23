<div class="stem"><span class="q_sub_index"> <?=$question['position']?></span>， <? echo $question['stem'] ?> </div>
<div class="content">

</div>

<?  if(empty($hideAnswer)) { ?>
    <div class="answer">
        <h3>答案：</h3>
        <?= $question['answer']; ?>
    </div>
    <div class="analysis"><h3>分析：</h3><? echo $question['analysis'] ?> </div>
<? } ?>




