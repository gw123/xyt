<?php

namespace frontend\controllers;
use Yii;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\File;
use common\models\FileQuery;
use common\utils\Qrcode;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use common\utils\Pdf2Img;
use yii\widgets\LinkPager;
use yii\widgets\MaskedInput;

/**
 * VideoController implements the CRUD actions for Video model.
 */
class TestController extends Controller
{

    public function actionTest2()
    {
        $this->layout = false;
       return $this->render( '/template/upload-image.php' );
    }

    public function  actionUpload()
    {


    }

    public function  actionTest1()
    {
        $query = new Query();
        $query->select("user.nickname,userId,article.title ,article.body ,article.createdTime");
        $query->from('user')->innerJoin('article',"user.id=article.userId")->limit(1);
        $total = $query->count();

        $pages = new Pagination(['totalCount' => 4 ,'pageParam'=>'currentPage','defaultPageSize'=>10]);

         echo $pages->offset;
        $query->offset($pages->offset)->limit($pages->limit)->all();

         echo LinkPager::widget([
         'pagination' => $pages,
        ]);

        return;
        $page = new LinkPager();
        echo $page->getView();

        $res = $query->createCommand()->queryOne();
        var_dump($total ,$res); exit();
        $log = new   \common\utils\Log();
        $this->trigger('send');

    }

    // 测试
    public function  actionTest()
    {
        $phpWord  =  new PhpWord();
       // $section = $phpWord->addSection(array('pageNumberingStart' => 1));
        $section = $phpWord->addSection(array('breakType' => 'continuous', 'colsNum' => 2));
       // $section = $phpWord->addSection(array('lineNumbering' => array()));  显示行号
        $section->addText('hello world');
        $section->addTextBreak(0);
        $section->addText('hello world2');

        $textRun =  $section->addTextRun();
        $textRun->addText("123456");
        $textRun->addText("123");
        $imageStyle = array(
            //'width'=>100,
            'wrappingStyle' => 'inline',
           // 'positioning' => 'absolute',
           // 'posHorizontalRel' => 'margin',
           // 'posVerticalRel' => 'line',
        );
        $textRun->addImage('http://17ky.xyt/images/default.png',$imageStyle);
        $textRun->addText("1234567");
        $textRun->addText("123456");
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('test1.docx');
    }

    //word 基础操作
    public  function  actionWordBase( )
    {
        $phpWord  =  new PhpWord();
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $songStyleName = 'oneUserDefinedStyle';
        $properties = $phpWord->getDocInfo();
        $properties->setCreator('rms');
        $properties->setCompany('中国教师研修网');
        $properties->setTitle('试卷导出');
        $properties->setDescription('make by gw123 , qq:963353840');
        $phpWord->setDefaultFontName('宋体');
        $phpWord->setDefaultFontSize(12);

        $phpWord->addFontStyle( $songStyleName, array('name' => 'Times New Roman', 'size' => 12, 'bold' => false));

        // 获取试题内容 3554891
        $response = file_get_contents('http://api.rms.yanxiu.com/question/info?question_id=[3554891,3556894,3556777]');
        $data = json_decode($response , true);
        if($data['ret']!==0)
        {
            return "数据有误";
        }

        $questions = $data['data'];
        $section = $phpWord->addSection();
        $QUESTION_TYPES = [1=>'单选题',2=>'多选题',3=>'填空题',4=>'判断题',5=>'材料阅读',6=>'问答题',7=>'连线',8=>'计算',9=>'听音选择',10=>'听音判断',11=>'听音连线',12=>'听音填空',13=>'归类',14=>'阅读理解',15=>'完形填空',16=>'翻译',17=>'改错',18=>'听力选择',19=>'听力填空',20=>'排序',21=>'听音排序',22=>'解答题',23=>'写作'];

        foreach ($questions as $index =>$question)
        {
            $section->addText("[试题位置]{$index}");
            $questionType = $QUESTION_TYPES[$question['type_id']];
            $section->addText("[题型]{$questionType}" );
            $sectionText = "[题号]{$question['id']}";
            $section->addText($sectionText , $songStyleName);
            if( isset( $question['memo'] ) && $question['memo']!= ''  )
            {
                $section->addText("[题目说明] {$question['memo']} ");
            }
            $sectionText = "[题干]{$question['stem']}";
            //echo $sectionText."\n\n";
            $this->addHtml($sectionText , $section);

            if( $question['content']&&isset($question['content']['choices']) )
            {
                $choices = $question['content']['choices'];
                $section->addText('[选项]');
                foreach ($choices as $index=>$choice)
                {
                    $choiceIndex = chr(ord('A')+$index);
                    $this->addHtml("{$choiceIndex}.".$choice , $section);
                }
            }

            if( $question['template']!='multi' && $question['template']!='listen' )
            {
                if($question['template']=='choice'){
                    foreach ($question['answer'] as $index=>$choice)
                    {
                        $choiceIndex = chr(ord('A')+$choice);
                        $this->addHtml("[答案]{$choiceIndex} ," , $section);
                    }
                }else if ( $question['template']=='fill' ){
                    foreach ($question['answer'] as $index=>$fill)
                    {
                        $this->addHtml(" [ {$fill} ] " , $section);
                    }
                }else{
                    $str = "[答案 ] ";
                    foreach ($question['answer'] as $index=>$ans)
                    {
                        $str .=$ans." ; ";
                    }
                    $this->addHtml($str , $section);
                }
            }

            $this->addHtml("[解析] ".$question['analysis'] , $section);
            if( isset($question['explanation']) )
            {
                $this->addHtml("[归因分析] ".$question['explanation'] , $section);
            }
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('export.docx');
        return 'success';
    }

    /***
     * @param $content
     */
    public  function   addHtml($content ,$section )
    {
        $rule  = '/<img.*?src="([^"]*)"\s*[^>]*?(data-latex="([^"]*)")?\s*(style="([^"]*)")?[\s\/]?>/';
        $images = [];
        $sectionText =preg_replace_callback($rule ,function($match) use( &$images){
            $src   = $match[1];
            #$style = $match[3];
            $images[] = $src;
            return "###";
        } , $content);

        $rule = "/<p[^>]*?>([\s\S]*?)<\/p>/";
        $sectionText = preg_replace( $rule ,'<br/>$1<br/>', $sectionText );

        $textRun = $section->addTextRun();
        $pices = explode('###',$sectionText);
        $len = count($pices);
        //echo $content;
        //var_dump($pices);
        foreach ( $pices  as $index=>$pice )
        {
           // echo "\n [pice1:] \n".$pice;
            $normalChar = [ chr(0) , chr(1) , chr(2) ,chr(3)];
            $pice = str_replace( $normalChar , '' , $pice);
            $pice = strip_tags($pice);
            $pice = str_replace( '&nbsp;','',$pice );
            //echo "\n [pice:] \n".$pice;
            if($pice)
            {
                $conent = str_replace('<br>' , '<br/>',$pice);
                $pices = explode('<br/>',$conent);
                $len1 = count($pices);
                foreach ( $pices  as $index1=>$pice )
                {
                    $textRun->addText($pice);
                    if( $len1-1 == $index1 ) continue;
                    $textRun->addTextBreak(0);
                }
                //$textRun->addText($pice);
            }
            if( $len-1 == $index ) break;
            $src = $images[$index];
            $textRun->addImage($src ,array('marginLeft'=>'1','align'=>'center', 'wrappingStyle'=>'inline' ));
        }
    }


    public  function  addBrToWord($conent ,$section)
    {
        $textRun = $section->addTextRun();
        $conent = str_replace('<br>' , '<br/>',$conent);
        $pices = explode('<br/>',$conent);
        $len = count($pices);
        //echo $content;
        //var_dump($pices);
        foreach ( $pices  as $index=>$pice )
        {
            // echo "\n [pice1:] \n".$pice;
            $normalChar = [ chr(0) , chr(1) , chr(2) ,chr(3)];
            $pice = str_replace( $normalChar , '' , $pice);
            $pice = strip_tags($pice);
            $pice = str_replace( '&nbsp;','',$pice );
            if($pice)
            { $textRun->addText($pice); }
            if( $len-1 == $index )
             $textRun->addTextBreak(0);
        }
    }

    /**
     * PDF2PNG
     * @param $pdf  待处理的PDF文件
     * @param $path 待保存的图片路径
     * @param $page 待导出的页面 -1为全部 0为第一页 1为第二页
     * @return      保存好的图片路径和文件名
     */
    public  function   actionPdf()
    {
        set_time_limit(0);
        $pdf = '/data/uploader/files/file/20170702/1498994073590025.pdf';
        $pdf2png = new Pdf2Img();
        //echo $pdf;  exit();
        $Return=$pdf2png->pdf2pngs('算法分析和设计' , $pdf);

        var_dump($Return);exit();

        $scount=count($s);
        for($i=0;$i<$scount;$i++)
        {
            echo "<div align=center><font color=red>Page ".($i+1)."</font><br><a href=\"".$s[$i]."\" target=_blank><img border=3 height=120 width=90 src=\"".$s[$i]."\"></a></div><p>";
        }

    }



}