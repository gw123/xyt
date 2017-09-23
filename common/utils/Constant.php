<?php
namespace common\utils;

use common\models\Task;
use Prophecy\PhpDocumentor\ClassAndInterfaceTagRetriever;

class Constant {

    public  static $CaiJiStatus = [
        CjStatus::defualt=>'全部',
        CjStatus::StepGet_Url=>'S1获取网址', CjStatus::StepGetContent=>'S2获取内容',
        CjStatus::StepGetContent=>'S3获取内容', CjStatus::StepGetContentImage=>'S4下载图片',
        CjStatus::StepPublish=>'S5已经发布',
        CjStatus::Error404=>'网址不存在' ,  CjStatus::ErrorTitle=>'解析标题失败',
        CjStatus::ErrorEmptyContent=>'获取内容为空' , CjStatus::StepDelete=>'删除' ,
    ];

    public  static  $CaiJiUrlLvl = [
        CjUrllvl::Lvl_1ist=>'列表' , CjUrllvl::Lvl_Article=>'文章',
        CjUrllvl::Lvl_Tag=>'标签'  , CjUrllvl::Lvl_Category=>'目录', CjUrllvl::Lvl_File=>'文件',
        CjUrllvl::Lvl_Video=>'视频', CjUrllvl::Lvl_Audio=>'音频',CjUrllvl::Lvl_Word=>'word',CjUrllvl::Lvl_Flash=>'flash'
        ];

    public  static  $Source_id  =
        [''=> '原创',  'github'=>'Github','bokuyuan'=> '博客园',  'xl'=>'新浪','tx'=>'tx' , 'zb'=>'正保' , 'csdn'=>'CSDN' , '51CTO'=>'51ctc' ,'baidu'=>'百度' ,'tengxun'=>'腾讯'];

    public  static $RecommenLvl= [ 10=>'普通', 1=> '一级推荐', 2=> '章节推荐', 3=> '小节推荐', 4=> '2级小节推荐', 5=> '首页推荐' ];

    public  static  $ArticleIsTop =['0'=>'普通' , '1'=>'头条'];



    public  static  $CourseStatus = [ CourseStatus::publish=>'发布',  CourseStatus::draft =>'草稿', CourseStatus::close =>'关闭' ];

    public  static $TaskType      = [  1=>'windos任务',  2=>'linux任务',3 =>'跨平台任务'];

    public  static $TaskStatus    = [   1=>'创建',  2=>'运行' , 3=> '运行结束' , 4=>'运行出错'  ];

    public  static  $PointStatus  = [ '0'=>'禁用',  '1'=>'开启',  '3'=>'待审核' ];

    public  static  $BookStatus  = [ 'published'=>'公开',  'unpublished'=>'不公开',  'trash'=>'已删除' ];
    public  static  $BookAuditStatus = ['pass'=>'通过','notpass'=>'审核失败','onpass'=>'正在审核'];
    public  static  $BookDevStatus =[ 'ondeve' => '正在连载', 'over' => '已经完结', ];

    public  static  $ArticleStatus  = [ 'published'=>'公开',  'unpublished'=>'不公开',  'trash'=>'已删除' ];
    public  static  $ArticleAuditStatus = ['pass'=>'通过','notpass'=>'审核失败','onpass'=>'正在审核'];

    public  static  $VideoStatus  = [ 'published'=>'公开',  'unpublished'=>'不公开',  'trash'=>'已删除' ];
    public  static  $VideoAuditStatus = ['pass'=>'通过','notpass'=>'审核失败','onpass'=>'正在审核'];

    public  static  $MaterialStatus  = [ 'published'=>'公开',  'unpublished'=>'不公开',  'trash'=>'已删除' ];
    public  static  $MaterialAuditStatus = ['pass'=>'通过','notpass'=>'审核失败','onpass'=>'正在审核'];


}

/***
 * 课程的发布状态
 * Class CourseStatus
 * @package common\utils
 */
class CourseStatus{
    const   publish = 'published';
    const   close   = 'closed';
    const   draft   = 'draft';
}
/***
 * 课程的发布状态
 * Class CourseStatus
 * @package common\utils
 */
class ArticleStatus{
    const   publish = 'published';
    const   close   = 'closed';
    const   draft   = 'draft';
}

/***
 * 文章采集状态
 * Class CjStatus
 * @package common\utils
 */
class CjStatus
{
    const   defualt = 0; //全部
    const   StepGet_Url = 1;
    const   StepGetContent = 2;
    const   StepGetContentImage = 3;
    const   StepReDo = 4;
    const   StepPublish = 5;

    const   StepDelete  = 9;
    const   Error404 = 10;
    const   ErrorEmptyContent = 11;
    const   ErrorTitle = 12;
}

/***
 * url  级别
 * Class CjUrllvl
 * @package common\utils
 */
class CjUrllvl{
    const  Lvl_1ist = 'list';    //采集列表
    const  Lvl_Article = 'article';  //采集文章
    const  Lvl_Tag = 'tag';      //采集标签
    const  Lvl_Category = 'category'; //采集目录
    const  Lvl_File = 'file';  //采集文件
    const  Lvl_Video = 'video';      //采集视频
    const  Lvl_Audio = 'audio'; //采集音频
    const  Lvl_Word = 'word'; //采集音频
    const  Lvl_Flash = 'Flash'; //采集音频
}

/****
 * 后台任务类型
 * Class TaskType
 * @package common\utils
 */
class TaskType  {
    const  Db_Back = 1;
    const  Cj_Tack = 2;

}

