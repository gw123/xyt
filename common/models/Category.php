<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $icon
 * @property string $path
 * @property integer $weight
 * @property string $groupId
 * @property string $parentId
 * @property string $description
 * @property string $orgId
 * @property string $orgCode
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'groupId'], 'required'],
            [['weight', 'groupId', 'parentId', 'orgId'], 'integer'],
            [['description'], 'string'],
            [['code'], 'string', 'max' => 64],
            [['name', 'icon', 'path', 'orgCode'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '分类ID',
            'code' => '分类编码',
            'name' => '分类名称',
            'icon' => '图标',
            'path' => '分类完整路径',
            'weight' => '分类权重',
            'groupId' => '分类组ID',
            'parentId' => '父分类ID',
            'description' => 'Description',
            'orgId' => 'Org ID',
            'orgCode' => '组织机构内部编码',
        ];
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }


    /**
     * getCategoryHashByCodes 根据codes获取所有分类信息
     *
     * @param mixed $codes
     * @static
     * @access public
     * @return void
     */
    public static function getCategoryHashByCodes($codes) {

        $roots = Category::find()->select(['id','name','code'])->where(['in','code',$codes])->asArray()->all();

        $rootIds = [];
        $rootHash = [];
        foreach($roots as $root) {
            $rootIds[] = $root['id'];
            $rootHash[$root['id']] = $root['code'];
        }

        $results = [];
        $rows = Category::find()->select(['id','groupId','name'])->where(['in','groupId',$rootIds])->asArray()->all();
        foreach($rows as $row) {
            $root = $row['groupId'];
            $code =  $rootHash[$root];
            if(isset($results[$code])) {
                $results[$code][$row['id']] = $row['name'];
            }else{
                $results[$code] = [$row['id']=>$row['name']];
            }
        }
        return $results;
    }
}
