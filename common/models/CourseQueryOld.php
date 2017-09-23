<?php
namespace common\models;
use Yii;

/**
 * This is the model class for table "{{%wp_question_chapter}}".
 *
 * @property integer $id
 * @property integer $parentid
 * @property integer $status
 * @property string $name
 * @property integer $lft
 * @property integer $rgt
 * @property integer $root
 */
class CourseQuery extends  \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%course}}';
    }

    public static function getDb()
    {
        return Yii::$app->dbEdu;
    }

    /**
     * @inheritdoc
     * @return Exam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Exam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public static function getCourseChapterTree($bookChapterId=1)
    {
        $query = self::find();
        $query->select('id,root,lvl,parentid,name,parents');
        $query->where(" root ={$bookChapterId}");
        $data= $query->asArray()->all();

        $data_chapter =  \common\utils\TreeUtils::list2tree($data);
        return $data_chapter;
    }

    /**
     *  获取所有的教材（课程）
     */
    public static  function  getCourse()
    {
        $query =  self::find();
        $query->select('id,title,middlePicture as cover');
        $query->where(" status = 'published' ")->limit(12);
        $data= $query->asArray()->all();
        $datahost = Yii::$app->params['DataHost'];
        foreach ($data as &$item)
        {
            $item['cover'] = str_replace('public://',$datahost.'/files/',$item['cover']);

        }
        return $data;
    }

}