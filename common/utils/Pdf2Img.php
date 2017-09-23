<?php
namespace common\utils;
use yii\base\Exception;
use yii\log\Logger;

use Yii;

/****
 * Yii 组件方式调用web调试器
 * Class Log
 * @package common\utils
 */
class  Pdf2Img {

    private  $dataPath;

    public   function  __construct($dataPath='')
    {
        if($dataPath=='')
           $dataPath =  Yii::$app->params['DataPath'];
        if( !is_dir($dataPath) )
            throw  new Exception('路径不存在');
         $this->dataPath = $dataPath;

        if(!extension_loaded('imagick'))
        {
            //throw  new Exception( '未检测imagick 扩展 ,请安装 imagick 扩展 ' );
        }
    }

    /***
     * 生成一个文件名
     * @param $bookname
     * @param $page
     * @return string
     */
    public   function  getFileName($bookname , $page)
    {
          $md5 = md5($bookname);
          $filename = "xytschool_".$page.".png";
          $datapath = $this->dataPath."/files/book/".$md5;
          if(!is_dir($datapath)) mkdir($datapath,0777,true);

          $filename = $datapath."/".$filename;
          if(is_file($filename)) unlink($filename);
        return $filename;
    }

    /***
     * 返回文件的路径
     * @param $bookname
     * @return string
     */
    public   function  getFilePath($bookname)
    {
        $md5 = md5($bookname);
        $datapath = $this->dataPath."files/book/".$md5;
        if(!is_dir($datapath)) mkdir($datapath,0777,true);
        return $datapath;
    }

    /*** 将 pdf 转为图片
     * @param $bookname
     * @param $pdf
     * @return string
     * @throws Exception
     */
    public   function  run_gs($bookname ,$pdf)
    {
        if(!is_file($pdf))
            throw  new Exception( '文件不存在 : '.$pdf );

        $filepath =  self::getFilePath($bookname);
        self::removeDir($filepath);
        $filepath =  self::getFilePath($bookname);

        $cmd = "gs -dSAFER -dBATCH -dNOPAUSE -r100 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ".
              "-sDEVICE=jpeggray -sOutputFile={$filepath}/xytschool_%03d.jpg {$pdf}";
        //echo $cmd;
        $output ='';
        exec($cmd , $output );

        return $output;
    }

    // 获取到执行命令 交给任务队列去执行
    public   function  get_gs_command($bookname ,$pdf)
    {
        if(!is_file($pdf))
            throw  new Exception( '文件不存在 : '.$pdf );

        $filepath =  self::getFilePath($bookname);
        self::removeDir($filepath);
        $filepath =  self::getFilePath($bookname);
//gs -dSAFER -dBATCH -dNOPAUSE -r100 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -sDEVICE=jpeggray -sOutputFile=./xytschool_%d.jpg book.pdf
        $cmd = "gs -dSAFER -dBATCH -dNOPAUSE -r100 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ".
            "-sDEVICE=jpeggray -sOutputFile={$filepath}/xytschool_%03d.jpg {$pdf}";

        return $cmd;
    }

    function removeDir($dirName)
    {
        if(! is_dir($dirName))
        {
            return false;
        }
        $handle = @opendir($dirName);
        while(($file = @readdir($handle)) !== false)
        {
            if($file != '.' && $file != '..')
            {
                $dir = $dirName . '/' . $file;
                is_dir($dir) ? removeDir($dir) : @unlink($dir);
            }
        }
        closedir($handle);

        return rmdir($dirName) ;
    }

    /***
     * @param $bookname  pdf 书籍名称
     * @param $page      页码
     * @return bool|string
     */
    public   function  getPageImage($bookname ,$page)
    {
         $path = self::getFilePath($bookname);
         $page = intval($page);
         if(!$page) return  false;

         $filepath= $path."/"."xytschool_".$page.".jpg";
         echo $filepath;
         if(is_dir($filepath))
             return $filepath;
         else
             return false;
    }

    /***
     *  pdf转为png 图片  这个方法不是很稳定
     * @param $bookname 图书的真实名称
     * @param $pdf      pdf 文件路径
     * @param $page     要转化的页码
     * @throws Exception
     */
    public  function pdf2pngs( $bookname,$pdf )
    {
        //$pdf = '/data/uploader/files/file/20170702/1498994073590025.pdf';
        if(!file_exists($pdf))
            throw  new Exception( 'pdf 文件不存在: '.$pdf );

         $im = new \Imagick();
         $im->setResolution(100,100);
         $im->setCompressionQuality(100);
        //echo $bookname;
         $index=0;
         $Return = [];
         $times = 0;
         $im->readImage( $pdf."[0]" );

         while (1)
         {
             try{
                 $im->readImage( $pdf."[{$index}]" );
             }catch (\Exception $e)
             {
                 echo $e->getMessage();
                 if($times++>10)
                     break;
                 else
                     continue;
             }

             $im->setImageFormat( 'png' );
             $filename = $this->getFileName($bookname,$index);

             if($im->writeImage($filename) == true)
             {
                 $Return[] = $filename;
             }else{
                 throw  new Exception( '图片写入失败: '.$filename );
             }
             $index ++;
         }

        return $Return;
    }

    public  function pdf2png( $bookname,$pdf ,$page=0)
    {
        //$pdf = '/data/uploader/files/file/20170702/1498994073590025.pdf';
        if(!file_exists($pdf))
            throw  new Exception( 'pdf 文件不存在: '.$pdf );

        $im = new \Imagick();
        $im->setResolution(100,100);
        $im->setCompressionQuality(100);


        $im->readImage($pdf."[".$page."]");

        foreach ($im as $Key => $Var)
        {
            $Var->setImageFormat('png');
            $filename = $this->getFileName($bookname,$page);
            if($Var->writeImage($filename) == true)
            {
                $Return[] = $filename;
            }
        }

        return $Return;
    }

}