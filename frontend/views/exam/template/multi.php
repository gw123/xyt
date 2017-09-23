
<?php
    use common\models\Question;
    $subQuestons = Question::getSubQuestions($question['id']);
?>

<?=$question['stem'] ?>
<?php
    foreach ($subQuestons as $index =>$subQuestion)
    {
        $template = $subQuestion['template'];
        $templates = ['answer','choice','fill','alter'];
        if(in_array($template,$templates))
        {
            echo $this->render($template.'.php',['question'=>$subQuestion]);
        }else{
            echo "template:: $template <br>";
        }
    }
?>



