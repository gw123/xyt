
<?php
    use common\models\Question;
    $subQuestons = Question::getSubQuestions($question['id']);
?>
<span class="q_sub_index"> <?=$question['position']?> ，</span>
<?=$question['stem'] ?>
<?php
    foreach ($subQuestons as $index =>$subQuestion)
    {
        $template = $subQuestion['template'];
        $templates = ['answer','choice','fill','alter'];
        if(in_array($template,$templates))
        {
            //strlen(($index+1))
            $subQuestion['position'] = '('.($index+1).')';
            echo ' <div class="sub_question">';
            echo $this->render($template.'.php',['question'=>$subQuestion,'hideAnswer'=>isset($hideAnswer)?$hideAnswer:0,$isSub=>1]);
            echo '</div>';
        }else{
            echo "template:: $template <br>";
        }
    }
?>



