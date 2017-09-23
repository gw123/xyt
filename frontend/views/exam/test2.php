<?php
//$this->registerJsFile("@web/js/lib/ng/angular.min.js",['depends' =>[yii\web\YiiAsset::className()]]);
//$this->registerJsFile("@web/js/controller/exam/test.js",['depends' =>[yii\web\YiiAsset::className()]]);
//$this->registerCssFile('@web/css/test.css');
?>
<?php
  $this->registerJsFile('@web/js/lib/ng/angular.min.js');
  $this->registerJsFile( '/js/controller/exam/exam.js' );
  $this->registerCssFile('/css/exam.css');
?>

<!-- 一个搜索框 -->

<div ng-app="exam"  ng-controller="searchController" >
      <div  >

          <div class="panel   panel-primary">
              <div class="panel-heading">
                  <h3 class="panel-title">搜索试题</h3>
              </div>
              <div class="panel-body">
                  <form class="form-horizontal" role="form">

                      <div class="form-group  has-success">
                          <label for="inputPassword" class="col-sm-2 control-label">
                              {{formName}}
                          </label>
                          <div class="col-sm-4">
                              <input class="form-control" id="disabledInput" type="text" placeholder="输入题号..." >
                          </div>


                          <label for="inputPassword" class="col-sm-2 control-label ">
                             测试类型
                          </label>
                          <div class="col-sm-4">
                              <select class="form-control ">
                                  <option value="">单元测试</option>
                                  <option value="">课后练习</option>
                              </select>
                          </div>

                      </div>

                      <div class="form-group  has-success">
                          <label class="col-sm-2 control-label">学科</label>
                          <div class="col-sm-4">
                              <select class="form-control ">
                                  <option value="">数学</option>
                                  <option value="">物理</option>
                                  <option value="">政治</option>
                                  <option value="">英语</option>
                              </select>
                          </div>
                          <label for="inputPassword" class="col-sm-2 control-label ">
                              试题类型
                          </label>
                          <div class="col-sm-4">
                              <select class="form-control ">
                                  <option value="">选择题</option>
                                  <option value="">填空题</option>
                              </select>
                          </div>
                      </div>

                      <div class="form-group has-success">

                              <label class="col-sm-2 control-label" for="inputSuccess">
                                  章节
                              </label>
                          <div class="col-sm-4">
                              <div class="input-group col-sm-12" >
                                      <input type="text" class="form-control">
                                      <div class="input-group-btn">
                                          <button type="button" class="btn  btn-primary "  ng-click="getChapter()"   data-toggle="modal" data-target="#chapterModal" >. . .</button>
                                      </div><!-- /btn-group -->
                              </div>
                           </div>

                          <label class="col-sm-2 control-label" for="inputSuccess">
                              知识点
                          </label>
                          <div class="col-sm-4">
                              <input type="text" class="form-control" id="inputSuccess">
                          </div>
                      </div>

                      <div class="form-group has-success">
                          <label class="col-sm-2 control-label" for="inputSuccess">
                             试卷来源
                          </label>
                          <div class="col-sm-4">
                              <input type="text" class="form-control" id="inputSuccess">
                          </div>
                          <label class="col-sm-2 control-label" for="inputSuccess">
                              出题人
                          </label>
                          <div class="col-sm-4">
                              <input type="text" class="form-control" id="inputSuccess">
                          </div>
                      </div>

                  </form>
              </div>

          </div>

      </div>


<!---模态框列表 --->
<!---章节选择模态框--->
<div class="modal fade" id="chapterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    选择章节
                </h4>
            </div>
            <div class="modal-body">
                     <select>
                         <option ng-repeat="item in items"   value="{{item}}"  ng-click="getSons()"> {{item}}  </option>
                     </select>
                    <select>
                        <option ng-repeat="item in item1"   value="{{item}}"  ng-click="getSons()"> {{item}}  </option>
                    </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary">保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->

</div>

</div>
<!-- app end -->



<!-- 按钮触发模态框 -->
<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
    开始演示模态框
</button>

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                   标题
                </h4>
            </div>
            <div class="modal-body">
                在这里添加一些文本
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary">
                   保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<!-- 模态框（Modal）end  -->