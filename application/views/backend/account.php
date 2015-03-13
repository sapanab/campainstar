<div class="boxed">
    <div class="boxinner">
        <div class="panel">

            <!-- Circular Form Wizard -->
            <!--===================================================-->
            <div id="demo-step-wz">
                <div class="wz-heading wz-w-label bg-success hd_bgcolor">

                    <!--Progress bar-->
                    <div class="progress progress-xs">
                        <div style="width: 15%;" class="progress-bar progress-bar-dark bg_yellow"></div>
                    </div>

                    <!--Nav-->
                    <ul class="wz-steps wz-icon-bw wz-nav-off text-lg">
                        <li class="col-xs-3">
                            <a data-toggle="tab" href="#demo-step-tab1">
                                <span class="icon-wrap icon-wrap-xs icon-circle bg-dark bg_yellow">
														<span class="wz-icon icon-txt text-bold">1</span>
                                <i class="wz-icon-done fa fa-check"></i>
                                </span>
                                <small class="wz-desc box-block">Account</small>
                            </a>
                        </li>
                        <li class="col-xs-3">
                            <a data-toggle="tab" href="#demo-step-tab2">
                                <span class="icon-wrap icon-wrap-xs icon-circle bg-dark bg_yellow">
														<span class="wz-icon icon-txt text-bold">2</span>
                                <i class="wz-icon-done fa fa-check"></i>
                                </span>
                                <small class="wz-desc box-block">Profile</small>
                            </a>
                        </li>
                        <li class="col-xs-3">
                            <a data-toggle="tab" href="#demo-step-tab3">
                                <span class="icon-wrap icon-wrap-xs icon-circle bg-dark bg_yellow">
														<span class="wz-icon icon-txt text-bold">3</span>
                                <i class="wz-icon-done fa fa-check"></i>
                                </span>
                                <small class="wz-desc box-block">Address</small>
                            </a>
                        </li>
                        <li class="col-xs-3">
                            <a data-toggle="tab" href="#demo-step-tab4">
                                <span class="icon-wrap icon-wrap-xs icon-circle bg-dark bg_yellow">
														<span class="wz-icon icon-txt text-bold">4</span>
                                <i class="wz-icon-done fa fa-check"></i>
                                </span>
                                <small class="wz-desc box-block">Finish</small>
                            </a>
                        </li>
                    </ul>
                </div>

                <!--Form-->
                <form class="form-horizontal">
                    <div class="panel-body">
                        <div class="tab-content">

                            <!--First tab-->
                            <div id="demo-step-tab1" class="tab-pane">
                                <div class="form-group">
                        <label class="col-lg-3 control-label txt">Full Name</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control txt" name="fullname" placeholder="Full Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label txt">Email Addresss</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control txt" name="emailaddresss" placeholder="Email Addresss">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label txt">Choose Password</label>
                        <div class="col-lg-7">
                            <input type="password" class="form-control txt" name="choosepassword" placeholder="Choose
Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label txt">Re Enter Password</label>
                        <div class="col-lg-7">
                            <input type="password" class="form-control txt" name="reenterpassword" placeholder="Re
Enter
Password">
                        </div>
                    </div>
                            </div>

                            <!--Second tab-->
                            <div id="demo-step-tab2" class="tab-pane fade">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">First name</label>
                                    <div class="col-lg-7">
                                        <input type="text" placeholder="First name" name="firstName" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Last name</label>
                                    <div class="col-lg-7">
                                        <input type="text" placeholder="Last name" name="lastName" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!--Third tab-->
                            <div id="demo-step-tab3" class="tab-pane">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Phone Number</label>
                                    <div class="col-lg-7">
                                        <input type="text" placeholder="Phone number" name="phoneNumber" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Address</label>
                                    <div class="col-lg-7">
                                        <input type="text" placeholder="Address" name="address" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!--Fourth tab-->
                            <div id="demo-step-tab4" class="tab-pane mar-btm text-center">
                                <h4>Thank you</h4>
                                <p class="text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                            </div>
                        </div>
                    </div>

                    <!--Footer button-->
                    <div class="panel-footer text-right">
                        <div class="box-inline">
                            <button type="button" class="previous btn btn-mint">Previous</button>
                            <button type="button" class="next btn btn-mint">Next</button>
                            <button type="button" class="finish btn btn-mint" disabled>Finish</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--===================================================-->
            <!-- End Circular Form Wizard -->

        </div>
    </div>
</div>
<!--===================================================-->
<!--END CONTENT CONTAINER-->

<script>
    $(document).ready(function () {
        $('#demo-step-wz').bootstrapWizard({
            tabClass: 'wz-steps',
            nextSelector: '.next',
            previousSelector: '.previous',
            onTabClick: function (tab, navigation, index) {
                return false;
            },
            onInit: function () {
                $('#demo-step-wz').find('.finish').hide().prop('disabled', true);
            },
            onTabShow: function (tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index + 1;
                var $percent = (index / $total) * 100;
                var wdt = 100 / $total;
                var lft = wdt * index;
                var margin = (100 / $total) / 2;
                $('#demo-step-wz').find('.progress-bar').css({
                    width: $percent + '%',
                    'margin': 0 + 'px ' + margin + '%'
                });


                // If it's the last tab then hide the last button and show the finish instead
                if ($current >= $total) {
                    $('#demo-step-wz').find('.next').hide();
                    $('#demo-step-wz').find('.finish').show();
                    $('#demo-step-wz').find('.finish').prop('disabled', false);
                } else {
                    $('#demo-step-wz').find('.next').show();
                    $('#demo-step-wz').find('.finish').hide().prop('disabled', true);
                }
            }
        });
    });
</script>