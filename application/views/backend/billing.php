<div class="boxed">
    <div class="boxinner">
        <h3 class="started">Get Started</h3>
        <p class="account">Account setup</p>
        <!-- Circular Form Wizard -->
        <!--===================================================-->
        <div id="demo-step-wz">
            <div class="menu">

                <!--Progress bar-->
                <!--
										<div class="progress progress-xs">
											<div style="width: 15%;" class="progress-bar progress-bar-dark"></div>
										</div>
-->

                <!--Nav-->
                <div class="align">
                    <div class="col-md-3">
                        <div class="circle circlecolor">
                            1
                        </div>
                        <div class="circletxt circletxtchange">Accounts</div>
                    </div>
                    <div class="col-md-3">
                        <div class="circle circlecolor">
                            2
                        </div>
                        <div class="circletxt circletxtchange">Campany</div>
                    </div>
                    <div class="col-md-3">
                        <div class="circle circlecolor">
                            3
                        </div>
                        <div class="circletxt circletxtchange">Setting</div>
                    </div>
                    <div class="col-md-3">
                        <div class="circle circlecolor">
                            4
                        </div>
                        <div class="circletxt circletxtchange">Billing</div>
                    </div>
                </div>
            </div>

            <!--Form-->
            <form class="form-horizontal bg">
                <div class="formspac divplus">

                    <div>Which Email system You use?</div>
                    <div>
                        <input type="text" class="form-control txt" name="username" placeholder="Username">
                    </div>
                    <br>
                    <div>Does your campany have brand guidlines</div>
                    <div class="brand">
                        <input type="radio" class="guildlines">&nbsp;Debit/Credit Card
                        <br>
                        <input type="radio" class="guildlines">&nbsp;Wire Tranfer
                        <br>
                        <input type="radio" class="guildlines">&nbsp;Cheque</div>
                </div>
                <!--Footer button-->
                <div class="button">

                    <a href="<?php echo site_url('account/setting'); ?>" class="back">Back</a>
                    <a href="<?php echo site_url('account/setting'); ?>" class="continue">Continue</a>

                </div>
            </form>
        </div>


    </div>
    <!--===================================================-->
    <!-- End Circular Form Wizard -->
</div>

