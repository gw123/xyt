<div class="stem"><h3>题干：</h3><? echo $question['stem'] ?> </div>

<?  if(empty($hideAnswer)) { ?>
    <div class="answer">
        <h3>答案：</h3>
        <?php
            $answers = json_decode($question['answer'],true);
            foreach ($answers as $index =>$ans)
            {  echo "<span>".($index+1)."</span> $ans ; "; }
        ?>

    </div>
    <div class="analysis"><h3>分析：</h3><?= $question['analysis'] ?> </div>
<? } ?>

