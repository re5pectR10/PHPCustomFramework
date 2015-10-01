<?= \FW\View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <?= \FW\Form::open(array('action' => \FW\Common::getBaseURL().'/user/login')) ?>
                <?= \FW\Form::text(array('name' => 'username', 'placeholder' => 'username')) ?>
                <?= \FW\Form::password(array('name' => 'password', 'placeholder' => 'password')) ?>
                <?= \FW\Form::submit(array('name' => 'submit', 'value' => 'Log In')) ?>
                <?= \FW\Form::close() ?>
                <p class="alert-danger">
                    <?= \FW\Session::getError() ?>
                </p>
            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2015</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
<?= \FW\View::getLayoutData('footer') ?>