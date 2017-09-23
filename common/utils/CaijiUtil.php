<?php
namespace  common\utils;

use Yii;
use common\utils\Curl;
use common\utils\Constant;
use common\utils\CjStatus;
use yii\base\Exception;

/****
 * Class Caiji
 * @package common\utils
 */
class  CaijiUtil{
    protected  $_config= [];
    /*
    $pcConfig = [
    'host'=>$host,
    'data_root'=>Yii::$app->params['DataPath'],
    'relative_path'=> Yii::$app->params['PcDownloadPath'],
    'list_rule'=>'',
    'list_mast_have'=>'[^http]',
    'title_rule'=>$titlerule,
    'title_filter'=>'_考研教育网',
    'content_rule'=>'',
    'content_start'=>$contentStart,
    'content_end'=>$contentEnd,
    'contentStartOffset'=>21,
    'contentEndOffset'=>21
    ];*/

    public  function  __construct($config)
    {
        Constant::$Source_id; //为了加载这个文件
        $this->_config = $config;
    }

    public  function  setConfig($config)
    {
        $this->_config = $config;
    }

    /*** 从列表中解析文章的具体地址列表
     * @param $lvl_pages  列表地址数组
     * @param $model  初始化模型
     * @param string $lvl_relative 地址相对位置
     */
    public function  parseUrlList( $lvl_pages , $model , $lvl_relative ='' )
    {
        $curl = new Curl('');
        $listRule  = $this->_config['list_rule'];
        //echo $listRule; exit();
        //爬虫抓取图片配置
        $host    = $this->_config['host'];
        $models = [];
        foreach ($lvl_pages as $ii=>$page)
        {
            $url = $host.$lvl_relative.$page;
            $curl->createCurl( $url );
            $status = $curl->getHttpStatus();
            if( !($status == 200 || $status=302) )
            {
                $model['url']=$url;
                $model['lvl'] = CjUrllvl::Lvl_1ist;
                $model['status'] = CjStatus::Error404;
                array_push($models , $model);
                echo "[ lvl1 ]  {$status}NotFound: {$url}\n";
                continue;
            }

            $content =  $curl->tostring();
            preg_match_all($listRule , $content , $match);
            array_shift($match[1]); array_shift($match[1]); array_shift($match[1]);
            $listUrls = $match[1];
            echo  "The <<".$page.">> Sum:".count($listUrls)."  \n";

            if(count($listUrls)==0)
            {
                $model['url']     = $url;
                $model['lvl']     = CjUrllvl::Lvl_1ist;
                $model['status']  = CjStatus::ErrorEmptyContent;
                array_push($models , $model);
                continue;
            }
            else{
                $model['url']  =$url;
                $model['lvl']  = CjUrllvl::Lvl_1ist;
                $model['status'] = CjStatus::StepGetContent;
                array_push($models , $model);
            }
            //echo "page[{$ii}] \n"; continue;
            foreach ($listUrls as $index=> $lvl_2_url)
            {
                //过滤条件
                if( strpos($lvl_2_url,'.shtml')===false && strpos($lvl_2_url,'.html')===false)    { echo "Pass : $lvl_2_url \n" ; continue; }
                if( strpos($lvl_2_url , 'mailto:' )!==false ) { echo "Pass : $lvl_2_url \n" ;  continue; }
                $index = ($ii+1).'_'.$index;
                $lvl_2_url = $host.$lvl_2_url ;
                //echo "Url : {$lvl_2_url} \n";
                $model['url']=$lvl_2_url;
                $model['status'] = CjStatus::StepGet_Url;
                $model['lvl']     = CjUrllvl::Lvl_Article;
                array_push($models , $model);
            }
            //sleep(20);
        }
        //$this->wirteToFile($models); exit();
        //$this->batchInsert($models);
        return $models;
    }

    /***
     * @param $url  采集网址
     * @param $config  配置
     */
    public function caijiContent( $lvl_2_url , $model  )
    {
        $dataRoot= $this->_config['data_root'];
        $pcRelativePaht = $this->_config['relative_path'];

        //标题 过滤标题
        $titlerule = $this->_config['title_rule'];
        $title_filter = $this->_config['title_filter'];
        //采集文章开始结束区域
        $contentStart = $this->_config['content_start'];
        $contentEnd = $this->_config['content_end'];
        //页面位置偏移
        $contentStartOffset = $this->_config['relative_path'];
        $contentEndOffset = $this->_config['relative_path'];

        $curl = new Curl('');
        $curl->createCurl( $lvl_2_url );
        $content =  $curl->tostring();
        $status = $curl->getHttpStatus();
        $id = $model['id'];
        if( !($status == 200 || $status=302) )
        {
            $model['status'] = CjStatus::Error404;
            echo "[ {$id} ] {$status} NotFound: {$lvl_2_url}\n";
            return  $model;
        }
        //echo CjStatus::ErrorEmptyContent;
        //echo $status."\n"; continue;
        if(empty($content))
        {
            $model['status'] = CjStatus::ErrorEmptyContent;
            echo "[ {$id} ] fied get content: {$lvl_2_url}\n";
            return $model;
        }
        else{
            preg_match($titlerule , $content ,$matchTitle);
            if( !isset( $matchTitle[1]) )
            {
                $model['url']   =   $lvl_2_url;
                $model['status'] = CjStatus::ErrorTitle;
                echo "[ {$id} ] title parse field: {$lvl_2_url}\n";
                return  $model;
            }

            $title  = $matchTitle[1];
            $title  =  mb_convert_encoding($title, "UTF-8" , "GBK");
            $title  = str_replace($title_filter,'',$title);
            if($title=='报错页面')
            {
                $model['url']   =   $lvl_2_url;
                $model['status'] = CjStatus::ErrorTitle;
                echo "[ {$id} ] title parse field: {$lvl_2_url}\n";
                return  $model;
            }
            $start =  strpos($content ,$contentStart);
            $end   =  strpos($content,$contentEnd);
            $article = substr( $content , $start+$contentStartOffset , $end -$start- $contentEndOffset);
            $article =  mb_convert_encoding($article, "UTF-8" , "GBK");
            $article = $this->replaceImage($article);
            //echo $article; exit();
            $model['title'] =$title;
            $model['content']=$article;
            $model['attach'] = $title;
            $model['status'] = CjStatus::StepGetContent;

            $title =  mb_convert_encoding($title , "GBK" , "UTF-8");
            echo "[{$id}] Title: {$title}\n";
            return  $model;
        }
    }

    public function  batchInsert($models)
    {
        $temp= [] ;
        $fields = [ 'source_id' ,'tag' ,'createtime' ,'url','lvl' ,'status'];
        $db = Yii::$app->db;
        $trans = $db->beginTransaction();
        try{
            foreach ( $models as $index=> $model)
            {
                $m = [ $model['source_id'] ,$model['tag'] , $model['createtime'] ,$model['url'] ,$model['lvl'] ,$model['status'] ];
                array_push($temp , $m);
                if($index%100==99)
                {
                    //var_dump($temp);
                    $db ->createCommand()->batchInsert('caiji' ,$fields ,$temp)->execute();
                    $temp = [];
                }
            }
            if(!empty($temp))
            {
                $db->createCommand()->batchInsert('caiji' ,$fields ,$temp)->execute();
            }
            $trans->commit();
        }catch (Exception $e)
        {
            $trans->rollBack();
            echo $e->getMessage();
            return false;
        }
        return  true;
    }

    public function   wirteToFile($data)
    {
        ob_start();
        var_dump($data);
        $data = ob_get_clean();
        file_put_contents("./data.log" , $data);
    }

    public  function  replaceImage( $content  )
    {
        // 去除title   alt   _src 标记
        $rule1 = '/ ((title=\"[^"]*\")|(alt=\"[^"]*\")|(oldsrc=\"[^"]*\"))/';
        $content = preg_replace($rule1,'',$content);
        $rule = '/<img([^>]*)\s* src=(\'|\")([^\'\"]+)(\'|\") ([^>]*)(\/)?>/';

        $content = preg_replace_callback( $rule , function($match){
            $url = $match[3];
            $style1 = $match[1];   //var_dump($match); exit();
            $style2 = $match[5];
            $newUrl = $this->download($url);
            //var_dump($match);
            if(!$newUrl)
            {
                echo "!#Download  faild: $url\n";
            }
            $img =  "<img src='{$newUrl}' {$style1} {$style2} />";
            return $img;
        } , $content );
        return $content;
    }

    public  function   download($url )
    {
        if(strpos($url,'http://')===false)
        $url     =  $this->_config['host'].$url;
        $relativePath  = $this->_config['relative_path'];
        $webRoot = $this->_config['data_root'];

        $image = @file_get_contents($url);
        $md5 = md5($image);
        if(empty($image)) return false;

        $ext = substr( $url , strripos($url, '.')+1);

        //$time = time()-rand(1,360000);
        //$date = date("Ymd", $time);
        $substr = "sub".substr( $md5 ,2,2 );
        $path = $relativePath."/".$substr.'/';

        $filename="17ky".$md5.'.'.$ext;
        $fullPath = $webRoot.'/'.$path.$filename;

        if( !is_dir($webRoot.'/'.$path) )   mkdir($webRoot.'/'.$path,0777,true);
        file_put_contents($fullPath,$image);

        $newUrl =  $path.'/'.$filename;
        return $newUrl;
    }

    /**
     * 下载音频 并且修改音频信息
     * @param $url
     */
    public static function  downloadAudio($url)
    {
        if(empty($url)) return false;
        echo "## $url \n";
        global $STATIC_CDN_URL;
        global $STATIC_CDN_ROOT_DIR;

        $image = file_get_contents($url);
        if(empty($image))  return false;

        $root = $STATIC_CDN_ROOT_DIR.'/';
        $time = time()-rand(100,2592000);

        $date = date("Y/md",$time);
        $path ='audio1/'.$date.'/';
        $filename= md5( $time ).rand(100000,999999).'.mp3';
        $fullPath = $root.$path.$filename;

        if(!is_dir($root.$path))  mkdir($root.$path,0777,true);
        file_put_contents($fullPath,$image);
        //修改歌曲信息

        $audio = new  \common\utils\AudioUtils();
        $pa = array('Title' => 'yanxiu.com', 'AlbumTitle' => 'yanxiu','Artist'=>'yanxiu','author'=>'yanxiu','APIC'=>'');
        $audio->SetInfo($fullPath, $pa);
        //生成url 路径
        $host = $STATIC_CDN_URL;
        $newUrl = $host.'/'.$path.$filename;
        return $newUrl;
    }

    /***
     * 过滤文章内容
     * @param $articles  文章数组
     * @return mixed
     */
    public static  function filterContent($articles)
    {
        $time = time();
        foreach ($articles as $a)
        {
            //从尾部截取
            if( strpos($a['body'], '<div class="xgrcsearch"')>0 )
                $a['body'] = substr($a['body'] ,0 , strpos($a['body'] , '<div class="xgrcsearch"') );

            //关键词替换
            $keys =  [ '正保'=>'' ,'考研教育网'=>'17考研' ];
            foreach ($keys as $key => $toVal)
            {
                $a['body'] = str_replace( $key  , $toVal , $a['body']  );
            }

            //正则替换
            //.........   去掉原网站中的链接
            //<a href="http://www.cnedu.cn/wangxiao/" target="_blank" class="bule" >研究生</a>
            $rule = '/<a href="([^"]*cnedu[^"]*)" [^>]*>(.*?)<\/a>/';
            $a['body'] = preg_replace( $rule  , '$2' , $a['body']  );

            //<p style="TEXT-INDENT: 2em"><strong>下载：</strong><a
            //.........   去掉多余的内容
            $rule = '/<p .*?><strong>下载：<\/strong><a.*?>.*?<\/a><\/p>/';
            $a['body'] = preg_replace( $rule  , '' , $a['body']  );

        }
        return $articles;

    }

    public static  function moveToVideo()
    {

    }
    /**/
    public static  function moveToMaterial()
    {

    }
}