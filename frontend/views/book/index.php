<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\utils\Constant;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的书籍';
//$this->params['breadcrumbs'][] = ['label' => '我的书籍', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建书籍', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            // 'userId',
            'title',
            // 'cover',
            // 'desc',
            // 'collectNum',
            // 'pv',
            // 'createdTime:datetime',
            // 'code',
            // 'price',
            // 'sort',
            // 'category',
            [
                'attribute'=>'category',
                'label'=>'目录',
                'format'=>'raw',
                'value'=>function($m){
                    $category = \common\models\CategorySearch::getLastCategoryName($m->category);
                    $str = '<button class="btn btn-sm chooserCategoryBtn" data-id="'. $m->id .'">'.$category.'</button>';
                    return $str;
                },
            ],
            // 'status',
             [
                 'attribute'=>'auditStatus',
                 'value'=>function($model) {
                   return  Constant::$BookAuditStatus[$model->auditStatus];
                 }
             ],
            [
                'attribute'=>'status',
                'value'=>function($model){
                 return Constant::$BookStatus[$model->status];
                }
            ],
            [
                'attribute'=>'deveStatus',
                'value'=>function($model){
                  return Constant::$BookDevStatus[$model->deveStatus];
                }
            ],
            // 'auditStatus',
            // 'deveStatus',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}  {update} {chapter}',
                'buttons' => [
                    'view'=>function($url,$model,$key){
                        $options = [
                            'class'=>'normal-icon icon-eye-open  bigger-130',
                            'title' => '查看详情',
                            'data-id' => $model->id,
                        ];
                        return Html::a( '', $url, $options);
                    },
                    'update'=>function($url,$model,$key){
                        $options = [
                            'class'=>' normal-icon icon-edit bigger-130',
                            'title' => '编辑',
                            'data-id' => $model->id,
                        ];
                        return Html::a( '', $url, $options);
                    },
                    'chapter'=>function($url,$model,$key){
                        $options = [
                            'class'=>' normal-icon icon-list bigger-130',
                            'title' => '查看章节',
                            'data-id' => $model->id,
                        ];
                        return Html::a( '', $url, $options);
                    },

                ],
                 'headerOptions' => ['width' => '80'],
            ],
        ],
    ]); ?>
</div>
