    <link rel="stylesheet" href="/xenon/css/fonts/linecons/css/linecons.css">
    <link rel="stylesheet" href="/xenon/css/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/xenon/css/bootstrap.css">
    <link rel="stylesheet" href="/xenon/css/xenon-core.css">
    <link rel="stylesheet" href="/xenon/css/xenon-forms.css">
    <link rel="stylesheet" href="/xenon/css/xenon-components.css">
    <link rel="stylesheet" href="/xenon/css/xenon-skins.css">
    <link rel="stylesheet" href="/xenon/css/custom.css">

    <script src="/xenon/js/jquery-1.11.1.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->





<div class="login-container">

    <div class="row">

        <div class="col-sm-6">

            <!--<script type="text/javascript">
                jQuery(document).ready(function($)
                {
                    // Reveal Login form
                    setTimeout(function(){ $(".fade-in-effect").addClass('in'); }, 1);


                    // Validation and Ajax action
                    $("form#login").validate({
                        rules: {
                            username: {
                                required: true
                            },

                            passwd: {
                                required: true
                            }
                        },

                        messages: {
                            username: {
                                required: 'Please enter your username.'
                            },

                            passwd: {
                                required: 'Please enter your password.'
                            }
                        },

                        // Form Processing via AJAX
                        submitHandler: function(form)
                        {
                            show_loading_bar(70); // Fill progress bar to 70% (just a given value)

                            var opts = {
                                "closeButton": true,
                                "debug": false,
                                "positionClass": "toast-top-full-width",
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };

                            $.ajax({
                                url: "data/login-check.php",
                                method: 'POST',
                                dataType: 'json',
                                data: {
                                    do_login: true,
                                    username: $(form).find('#username').val(),
                                    passwd: $(form).find('#passwd').val(),
                                },
                                success: function(resp)
                                {
                                    show_loading_bar({
                                        delay: .5,
                                        pct: 100,
                                        finish: function(){

                                            // Redirect after successful login page (when progress bar reaches 100%)
                                            if(resp.accessGranted)
                                            {
                                                window.location.href = 'dashboard-1.html';
                                            }
                                        }
                                    });


                                    // Remove any alert
                                    $(".errors-container .alert").slideUp('fast');


                                    // Show errors
                                    if(resp.accessGranted == false)
                                    {
                                        $(".errors-container").html('<div class="alert alert-danger">\
												<button type="button" class="close" data-dismiss="alert">\
													<span aria-hidden="true">&times;</span>\
													<span class="sr-only">Close</span>\
												</button>\
												' + resp.errors + '\
											</div>');


                                        $(".errors-container .alert").hide().slideDown();
                                        $(form).find('#passwd').select();
                                    }
                                }
                            });

                        }
                    });

                    // Set Form focus
                    $("form#login .form-group:has(.form-control):first .form-control").focus();
                });
            </script>-->

            <!-- Errors container -->
            <div class="errors-container">


            </div>

            <!-- Add class "fade-in-effect" for login form effect -->
            <form method="post" role="form" id="login" class="login-form fade-in-effect in">

                <div class="login-header">
                    <a href="dashboard-1.html" class="logo">
                        <img src="/xenon/images/logoblack.png" alt="" width="80" />
                        <span>登录</span>
                    </a>

                    <p><?= $model->getFirstError('password') ? : '' ?></p>
                </div>


                <div class="form-group">
                    <label class="control-label" for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" autocomplete="off" />
                </div>

                <div class="form-group">
                    <label class="control-label" for="passwd">Password</label>
                    <input type="password" class="form-control" name="password" id="passwd" autocomplete="off" />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary  btn-block text-left">
                        <i class="fa-lock"></i>
                        登 录
                    </button>
                </div>

                <div class="login-footer">
                    <label class="inline">
                        <input type="checkbox" value="1" name="rememberMe" class="ace"/>
                        <span class="lbl"> 记住我</span>
                    </label>

                </div>

            </form>



        </div>

    </div>

</div>



<!-- Bottom Scripts -->
<script src="/xenon/js/bootstrap.min.js"></script>
<script src="/xenon/js/TweenMax.min.js"></script>
<script src="/xenon/js/resizeable.js"></script>
<script src="/xenon/js/joinable.js"></script>
<script src="/xenon/js/xenon-api.js"></script>
<script src="/xenon/js/xenon-toggles.js"></script>
<script src="/xenon/js/jquery-validate/jquery.validate.min.js"></script>
<script src="/xenon/js/toastr/toastr.min.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="/xenon/js/xenon-custom.js"></script>

</body>
</html>
