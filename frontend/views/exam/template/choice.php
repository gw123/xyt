  <div class="stem"><h3>题干：</h3><? echo $question['stem'] ?> </div>
    <div class="content">
        <h3>选项：</h3>
        <div class="choice">
            <?php  $content = json_decode($question['content'] , true);
               // var_dump($content);
                if(is_array($content))
                 foreach ( $content['choices'] as $index=>$item){ ?>
                <?php echo $index.".".$item."<br>"  ;  ?>
            <?php } ?>
        </div>
    </div>

<?  if(empty($hideAnswer)) { ?>
    <div class="answer">
        <h3>答案：</h3>
        <?= $question['answer']; ?>
    </div>
    <div class="analysis"><h3>分析：</h3><? echo $question['analysis'] ?> </div>
<? } ?>




