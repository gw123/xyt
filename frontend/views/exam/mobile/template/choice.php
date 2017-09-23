
  <div class="stem"> <span class="q_sub_index"> <?=$question['position']?></span>， <? echo $question['stem'] ?> </div>
    <div class="content">

        <div class="choice">
            <?php  $content = json_decode($question['content'] , true);
               // var_dump($content);
                if(is_array($content))
                 foreach ( $content['choices'] as $index=>$item){ ?>
                     <div class="form-item cf choice_item">
                         <label class="radio">
                             <input type="radio" value="{$index}" name="{$index1}_{$index2}">  <?php echo $index.".".$item."<br>"  ;  ?>
                         </label>
                     </div>
                <?php } ?>
        </div>
        <div style="clear: both"></div>
    </div>

<?  if(empty($hideAnswer)) { ?>
    <div class="answer">
        <h3>答案：</h3>
        <?= $question['answer']; ?>
    </div>
    <div class="analysis"><h3>分析：</h3><? echo $question['analysis'] ?> </div>
<? } ?>




