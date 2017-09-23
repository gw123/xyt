<div class="page-content">
    <div class="page-header">
        <h1>  个人资料
            <small> <i class="icon-double-angle-right"></i> 修改个人资料 </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <form class="form-horizontal" role="form" id="settingForm">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 姓名 </label>
                    <div class="col-sm-9">
                        <input type="text" id="form-field-1"  name='truename' placeholder="" class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="space-4"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 生日 </label>
                    <div class="col-sm-9">
                        <input type="text" id="form-field-1"  name='birthday' placeholder="" class="col-xs-10 col-sm-5 input-mask-date" />
                    </div>
                </div>
                <div class="space-4"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 性别 </label>
                    <div class="col-sm-9">
                        <label>
                            <span > 男</span>
                            <input type="radio" name="gender" value="male">&nbsp;&nbsp;&nbsp;&nbsp;
                        </label>

                        <label>
                            <span > 女</span>
                            <input type="radio" name="gender" value="female" >&nbsp;&nbsp;&nbsp;&nbsp;
                        </label>
                        <label>
                            <span > 保密</span>
                            <input type="radio"  name="gender" value="secret">
                        </label>
                    </div>
                </div>
                <div class="space-4"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 微信号码 </label>
                    <div class="col-sm-9">
                        <input type="text" id="form-field-1"  name='weixin' placeholder="" class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="space-4"></div>


                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 微博 </label>
                    <div class="col-sm-9">
                        <input type="text" id="form-field-1"  name='weibo' placeholder="" class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="space-4"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> qq </label>
                    <div class="col-sm-9">
                        <input type="text" id="form-field-1"  name='qq' placeholder="" class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="space-4"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 城市 </label>
                    <div class="col-sm-9">
                        <input type="text" id="form-field-1"  name='city' placeholder="" class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="space-4"></div>


                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 学校 </label>
                    <div class="col-sm-9">
                        <input type="text" id="form-field-1"  name='school' placeholder="" class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="space-4"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 兴趣 </label>
                    <div class="col-sm-9">
                        <input type="text" id="form-field-1"  name='interest' placeholder="" class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="space-4"></div>


                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 我的签名 </label>
                    <div class="col-sm-9">
                        <textarea rows="3" name='signature' placeholder="" class="col-xs-10 col-sm-5" >
                        </textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 自我简绍 </label>
                    <div class="col-sm-9">
                        <textarea rows="5" name='about' placeholder="" class="col-xs-10 col-sm-5" >
                        </textarea>
                    </div>
                </div>

                <div class="space-4"></div>

                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn btn-info submit" type="button" >
                            <i class="icon-ok bigger-110"></i>修改
                        </button>
                        &nbsp; &nbsp; &nbsp;
                        <button class="btn" type="reset">
                            <i class="icon-undo bigger-110"></i>重置
                        </button>
                    </div>
                </div>

            </form>


            <script src="/home/js/jquery.maskedinput.min.js"></script>

            <script>

                var setting = <?php echo  json_encode($setting)?>;
                for( var i in setting)
                {
                    if(i=='gender') continue;
                    $('#settingForm [name="'+i+'"]'  ).val( setting[i] );
                }
                var gender = setting['gender'];

                if(gender=='male')
                    $("[name='gender']").eq(0).attr("checked",true);
                else if(gender=='female')
                    $("[name='gender']").eq(1).attr("checked",true);
                else
                    $("[name='gender']").eq(2).attr("checked",true);

                $('#settingForm .submit').click(function () {
                    var formData = $('#settingForm').serializeArray()
                    var data = {};
                    for ( var  index in formData)
                    {
                        var name  = formData[index]['name'];
                        var value = formData[index]['value'];
                        data[name]=value;
                    }

                    UserService.updateSetting(data,function (response) {
                        if(response.status==1)
                        {
                            $.alert('修改成功');
                            window.location.reload();
                        }else {
                            $.waring('修改失败');
                        }
                    })
                });

                $('.input-mask-date').mask('9999-99-99');

            </script>

        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->