<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property string $id
 * @property string $title
 * @property string $subtitle
 * @property string $status
 * @property integer $buyable
 * @property string $buyExpiryTime
 * @property string $type
 * @property integer $maxStudentNum
 * @property double $price
 * @property double $originPrice
 * @property double $coinPrice
 * @property double $originCoinPrice
 * @property string $expiryMode
 * @property string $expiryDay
 * @property string $showStudentNumType
 * @property string $serializeMode
 * @property double $income
 * @property string $lessonNum
 * @property string $giveCredit
 * @property string $rating
 * @property string $ratingNum
 * @property string $vipLevelId
 * @property string $categoryId
 * @property string $categorys
 * @property string $smallPicture
 * @property string $middlePicture
 * @property string $largePicture
 * @property string $about
 * @property string $teacherIds
 * @property string $goals
 * @property string $audiences
 * @property integer $recommended
 * @property string $recommendedSeq
 * @property string $recommendedTime
 * @property string $locationId
 * @property string $parentId
 * @property string $address
 * @property string $studentNum
 * @property string $hitNum
 * @property string $noteNum
 * @property string $userId
 * @property string $discountId
 * @property double $discount
 * @property string $deadlineNotify
 * @property integer $daysOfNotifyBeforeDeadline
 * @property string $watchLimit
 * @property string $useInClassroom
 * @property string $singleBuy
 * @property string $createdTime
 * @property string $updatedTime
 * @property integer $freeStartTime
 * @property integer $freeEndTime
 * @property integer $approval
 * @property integer $locked
 * @property integer $maxRate
 * @property integer $tryLookable
 * @property integer $tryLookTime
 * @property string $conversationId
 * @property string $orgId
 * @property string $orgCode
 * @property string $category
 * @property string $chapter
 * @property string $point
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'userId', 'createdTime'], 'required'],
            [['status', 'expiryMode', 'showStudentNumType', 'serializeMode', 'tags', 'about', 'teacherIds', 'goals', 'audiences', 'deadlineNotify', 'useInClassroom'], 'string'],
            [['buyable', 'buyExpiryTime', 'maxStudentNum', 'expiryDay', 'lessonNum', 'giveCredit', 'rating', 'ratingNum', 'vipLevelId', 'categoryId', 'recommended', 'recommendedSeq', 'recommendedTime', 'locationId', 'parentId', 'studentNum', 'hitNum', 'noteNum', 'userId', 'discountId', 'daysOfNotifyBeforeDeadline', 'watchLimit', 'singleBuy', 'createdTime', 'updatedTime', 'freeStartTime', 'freeEndTime', 'approval', 'locked', 'maxRate', 'tryLookable', 'tryLookTime', 'orgId'], 'integer'],
            [['price', 'originPrice', 'coinPrice', 'originCoinPrice', 'income', 'discount'], 'number'],
            [['title', 'subtitle'], 'string', 'max' => 1024],
            [['type', 'smallPicture', 'middlePicture', 'largePicture', 'address', 'conversationId', 'orgCode'], 'string', 'max' => 255],
            [['category', 'chapter', 'point'], 'string', 'max' => 548],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '课程ID',
            'title' => '课程标题',
            'subtitle' => '课程副标题',
            'status' => '课程状态',
            'buyable' => '是否开放购买',
            'buyExpiryTime' => '购买开放有效期',
            'type' => '课程类型',
            'maxStudentNum' => '直播课程最大学员数上线',
            'price' => '课程价格',
            'originPrice' => '课程人民币原价',
            'coinPrice' => 'Coin Price',
            'originCoinPrice' => '课程虚拟币原价',
            'expiryMode' => '有效期模式（截止日期|天数|不设置）',
            'expiryDay' => '课程过期天数',
            'showStudentNumType' => '学员数显示模式',
            'serializeMode' => '连载模式',
            'income' => '课程销售总收入',
            'lessonNum' => '课时数',
            'giveCredit' => '学完课程所有课时，可获得的总学分',
            'rating' => '排行分数',
            'ratingNum' => '投票人数',
            'vipLevelId' => '可以免费看的，会员等级',
            'categoryId' => '分类ID',
            'tags' => '标签IDs',
            'smallPicture' => '小图',
            'middlePicture' => '中图',
            'largePicture' => '大图',
            'about' => '简介',
            'teacherIds' => '显示的课程教师IDs',
            'goals' => '课程目标',
            'audiences' => '适合人群',
            'recommended' => '是否为推荐课程',
            'recommendedSeq' => '推荐序号',
            'recommendedTime' => '推荐时间',
            'locationId' => '上课地区ID',
            'parentId' => '课程的父Id',
            'address' => '上课地区地址',
            'studentNum' => '学员数',
            'hitNum' => '查看次数',
            'noteNum' => '课程笔记数量',
            'userId' => '课程发布人ID',
            'discountId' => '折扣活动ID',
            'discount' => '折扣',
            'deadlineNotify' => '开启有效期通知',
            'daysOfNotifyBeforeDeadline' => 'Days Of Notify Before Deadline',
            'watchLimit' => '课时观看次数限制',
            'useInClassroom' => '课程能否用于多个班级',
            'singleBuy' => '加入班级后课程能否单独购买',
            'createdTime' => '课程创建时间',
            'updatedTime' => '最后更新时间',
            'freeStartTime' => 'Free Start Time',
            'freeEndTime' => 'Free End Time',
            'approval' => '是否需要实名认证',
            'locked' => '是否上锁1上锁,0解锁',
            'maxRate' => '最大抵扣百分比',
            'tryLookable' => 'Try Lookable',
            'tryLookTime' => 'Try Look Time',
            'conversationId' => 'Conversation ID',
            'orgId' => 'Org ID',
            'orgCode' => '组织机构内部编码',
            'category' => '标签',
            'chapter' => '章节',
            'point' => '知识点',
        ];
    }

    /**
     * @inheritdoc
     * @return CourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseQuery(get_called_class());
    }
}
