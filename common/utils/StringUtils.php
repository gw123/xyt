<?php
namespace common\utils;
use yii;

class StringUtils {
    public static function plain($text, $length = 0)
    {
        $text = strip_tags($text);

        $text = str_replace(array("\n", "\r", "\t") , '', $text);
        $text = str_replace('&nbsp;' , ' ', $text);
        $text = trim($text);

        $length = (int) $length;
        if ( ($length > 0) && (mb_strlen($text) > $length) )  {
            $text = mb_substr($text, 0, $length, 'UTF-8');
            $text .= '...';
        }

        return $text;
    }

    public static function decodeBBCode($bbCode,$prefix='') {
        $isFind = preg_match_all("#\[image\].*?\[\/image\]|\[video\].*?\[\/video\]#", $bbCode, $matches);
        if($isFind) {
            foreach ($matches[0] as $value) {
                $url = str_replace(array('[image]', '[/image]'), '', $value);
                $url = $prefix.$url;
                $bbCode = str_replace($value,'<img src="'.self::getResourceUrl($url).'"/>',$bbCode);
            }
        }
        return $bbCode;
    }

    public static function getResourceUrl($url) {
        if ($url) {
            if(strpos($url,'http:') === 0) {
                return $url;
            }
            return Yii::$app->params['STATIC_CDN_URL'].$url;
        }else {
            return '';
        }
    }

    public static function getRomanNumber($number) {
        $romanNumbers = ['I','II','III','IV','V','VI','VII','VIII','IX','X'];
        return $romanNumbers[$number-1];

    }

    public static function stripTags($text) {
        $text =  preg_replace("/\[\[.*?\]\]/",'(_)',$text);
        $allowed_tags = "<sub><sup><img>";
        $text = strip_tags($text,$allowed_tags);
        return $text;
    }


    public static function getCategoryLabel($ids,$category) {
        if(!$ids) {
            return "";
        }
        $label = '';

        if(empty($ids)) return   '';

        foreach($ids as $id) {
            if(isset($category[$id])) {
                $label .= $category[$id] . ' ';
            }
        }
        return rtrim($label);
    }

    public static function getPointLabel($ids,$point) {
        if(!$ids) {
            return "";
        }
        $label = '';
        foreach($ids as $id) {
            if(isset($point[$id])) {
                $label .= $point[$id] . ' ';
            }
        }
        return $label;
    }

    public static function formatBytes($size) { 
      $units = array(' B', ' KB', ' MB', ' GB', ' TB'); 
      for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024; 
      return round($size, 2).$units[$i]; 
     }


    public static function getFormatLabel($ids,$formats) {
        $label = '';
        foreach($ids as $id) {
            if(isset($formats[$id])) {
                $label .= $formats[$id] . ' ';
            }
        }
        return $label;
    }


    public static function arrayRemove($array,$v) {

        foreach($array as $key=>$value){    
            if($value == $v){ 
                unset($array[$key]); 
            }    
        }
        return $array;

    } 

    public static function convertNumber($number) {
        $number_list = ["零", "一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二", "十三", "十四", "十五", "十六", "十七", "十八", "十九", "二十"];
        if(array_key_exists($number, $number_list))
            return $number_list[$number];
        else
            return $number;
    }

    /**
    * 压缩html : 清除换行符,清除制表符,去掉注释标记
    * @param $string
    * @return 压缩后的$string
    * */
    public static function compressHtml($string) {
        $string = str_replace("\r\n", '', $string); //清除换行符
        $string = str_replace("\n", '', $string); //清除换行符
        $string = str_replace("\t", '', $string); //清除制表符
        $pattern = array (
            "/> *([^ ]*) *</", //去掉注释标记
            "/[\s]+/",
            "/<!--[^!]*-->/",
            "'/\*[^*]*\*/'"
        );
        $replace = array (
            ">\\1<",
            " ",
            "",
            ""
        );
        return preg_replace($pattern, $replace, $string);
    } 

    /**
     * parseCategory 根据category解析出学段，学科等信息
     * 
     * @param mixed $category 
     * @static
     * @access public
     * @return void
     */
    public static function parseCategory($categories) {
        if(!is_array($categories)) {
            $categories = explode(',',$categories);
        }
        $subject = false;
        $term = false;
        foreach($categories as $category) {
            if(isset(Constant::$COMMON_TERMS[$category])) {
                $term = $category;
            }
            if(isset(Constant::$COMMON_SUBJECT[$category])) {
                $subject = $category;
            }
        }
        return ['term'=>$term,'subject'=>$subject];
    }

    public static function getHashValue($arr) {
        $res = [];
        foreach($arr as $row) {
            foreach($row as $k=>$v) {
                $res[$k] = $v;
            }
        }
        return $res;
    }

    /**
     * 1,2,3,4格式的数据验证
     */
    public static function verifyMultiValues($str)
    {
        if($str)
        {
            $data = explode(',', $str);
            return count($data) == count(array_filter($data));
        }
        return true;
    }

    /**
     * 1,2,3,4转A,B,C,D
     */
    public static function numberToLetter($str)
    {
        if($str||$str==='0')
        {
            $array = explode(',', $str);
            $letters = [];
            foreach ($array as $number)
            {
                array_push($letters, chr($number + 65));
            }
            return implode(',', $letters);
        }
        return '';
    }

    /**
     * A,B,C,D转1,2,3,4
     */
    public static function letterToNumber($str)
    {
        if($str)
        {
            $array = explode(',', $str);
            $num = [];
            foreach ($array as $arr)
            {
                array_push($num, ord(strtoupper($arr)) - 65);
            }
            return implode(',', $num);
        }
        return '';
    }

    /**
     * 检测连线 答案的选项
     */
    public static function  checkConnectAnswer($answer)
    {
        $array = explode(',', $answer);
        if(count($array)!=2)   return false;
        if($array[0]<'A'||$array[0]>'Z')  return false;

        if($array[1]<'A'||$array[1]>'Z') return false;

      return true;
    }

    /**
     * @param $str
     * 过滤多余的<br>
     */
    public static function formatHtml($str)
    {
        $pattern1='/(<br>|<\/br>){2,}/';
        $pattern2='/<\/p><br>/';
        $pattern3='/<br><\/p>/';
        // preg_match_all('');

        $str= preg_replace($pattern1,'<br>',$str);
        $str= preg_replace($pattern2,'</p>',$str);
        $str= preg_replace($pattern3,'</p>',$str);
        return $str;
    }

    /**
     * 特殊字符回转 如 &lt;转为<
     */
    public static function revertHtml($html)
    {
        return $html;
//        return preg_replace('/&#39;/', '\'', htmlspecialchars_decode($html));
    }

    /**
     * 判断数组是否有空值
     * @param $array
     */
    public static function arrayFilter($array)
    {
        return count(array_filter($array, function($val){return trim($val) != '';})) != count($array);
    }

    public static function sphinxEscape($text)
    {
        return addslashes(preg_replace('/\/|-|\(|\)/', '', $text));
    }

    public static function isMathEmpty($text)
    {
        $text = trim($text);
        return $text == '';
    }


    /**
     * 矫正公式图片
     * @param $content
     * @return mixe
     *
     */
    public  static  function   latexFilter( $content ,&$question )
    {
        return $content;
        $convert_index= Yii::$app->params['CONVERT_INDEX'];
        //if(StringUtils::getCategoryLabel($question['category'],CONSTANT::$COMMON_SUBJECT) != "数学")
        //    return $content;

        $rule = '/<img class="kfformula" src=".+?" data-latex="(.+?)".*?\/>/';
        //新题循环部分
        if( $question['id']>$convert_index )
        {
            $content  = preg_replace_callback(  $rule  ,
                function($matche) {

                    if(strstr($matche[1] , '\\cdot }_'))
                    {
                        preg_match( '/src=\"(.*?)\" /' ,$matche[0] ,$res );
                        $img = '<img style="VERTICAL-ALIGN:-3px" src="'.$res[1].'" alt="" />';
                        return sprintf($img,$matche[1]);
                    }
                    return $matche[0];
                },$content);
            return     $content;
        }

        //转换旧题      判读段条件id  而且是数学题目 \cdot }_
       $content  = preg_replace_callback($rule  ,
           function($matche){
                 $rule1 = '/△/';
                $matche[1] = preg_replace($rule1,'\triangle ',$matche[1]);
                $len1 =  strlen($matche[1]);
                $len2 =  mb_strlen($matche[1]);
                if( $len1 != $len2 )  //判断是否有中文
                {
                    return $matche[0];
                }

                $mathtexcgi = Yii::$app->params['MATHTEX_CGI'];

                if( strstr($matche[1] , '\\frac') )
                {
                    $img = '<img style="VERTICAL-ALIGN:-10px" src="'.$mathtexcgi.'?\\png \dpi{110}\gammacorrection{1.2}\ %s" alt="" />';
                }else if( strstr($matche[1] , 'frac')  )
                {
                    $img = '<img style="VERTICAL-ALIGN:-10px" src="'.$mathtexcgi.'?\\png \dpi{110}\gammacorrection{1.2}\\%s" alt="" />';
                }
                else if( strstr($matche[1] , '\\sum'))
                {
                    $img = '<img style="VERTICAL-ALIGN:-18px" src="'.$mathtexcgi.'?\\png \dpi{110}\gammacorrection{1.2}\ %s" alt="" />';
                }
                else if(strstr($matche[1] , '\\cdot'))
                {
                    if(strstr($matche[1],'\\cdot }_'))
                    {
                        preg_match('/src=\"(.*?)\" /', $matche[0], $res);
                        $img = '<img style="VERTICAL-ALIGN:-3px" src="' . $res[1] . '" alt="" />';
                    }
                    $img = '<img style="VERTICAL-ALIGN:-3px" src="'.$mathtexcgi.'?\\png \dpi{105}\gammacorrection{1} \ %s" alt="" />';
//                    else{
//                       return  preg_replace('/\\\cdot /', '·',$matche[0]);
//                    }
                }
                else if(strstr($matche[1] , '\\sqrt'))
                {
                    if(strstr($matche[1] , '\\sqrt['))
                    {
                        $img = '<img style="VERTICAL-ALIGN:-1px" src="'.$mathtexcgi.'?\\png \dpi{108}\gammacorrection{1.3}\ %s" alt="" />';
                    }else{
                        $img = '<img style="VERTICAL-ALIGN:-1px" src="'.$mathtexcgi.'?\\png \dpi{105}\gammacorrection{1}\ %s" alt="" />';
                    }
                }else if(strstr($matche[1] , 'sqrt'))
                {
                    if(strstr($matche[1] , 'sqrt['))
                    {
                        $img = '<img style="VERTICAL-ALIGN:-1px" src="'.$mathtexcgi.'?\\png \dpi{108}\gammacorrection{1.3}\%s" alt="" />';
                    }else{
                        $img = '<img style="VERTICAL-ALIGN:-1px" src="'.$mathtexcgi.'?\\png \dpi{105}\gammacorrection{1}\%s" alt="" />';
                    }
                }

                else
                {
                       $img = '<img style="VERTICAL-ALIGN:-3px" src="'.$mathtexcgi.'?\\png \dpi{105}\gammacorrection{1}\ %s" alt="" />';
                }
                return sprintf($img,$matche[1]);
        }, $content );

        return  $content;
    }

    /**
     * 反转义
     * @param $string
     * @return mixed|string
     */
    public static function htmlspecialcharsDecode($string)
    {
        $result = htmlspecialchars_decode($string);
        $result = str_replace('&#39;', '\'', $result);
        return $result;
    }

}
?>

