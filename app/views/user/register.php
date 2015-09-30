<?= \FW\View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <?= \FW\Form::open(array('action' => \FW\Common::getBaseURL().'/user/register')) ?>
                <?= \FW\Form::text(array('name' => 'username', 'value' => isset(\FW\Session::oldInput()['username']) ? \FW\Session::oldInput()['username'] : '', 'placeholder' => 'username')) ?>
                <?= \FW\Form::password(array('name' => 'password', 'placeholder' => 'password')) ?>
                <?= \FW\Form::text(array('name' => 'email', 'placeholder' => 'email', 'value' => isset(\FW\Session::oldInput()['email']) ? \FW\Session::oldInput()['email'] : '')) ?>
                <?= \FW\Form::submit(array('name' => 'submit', 'value' => 'Sign In')) ?>
                <?= \FW\Form::close() ?>
                <p class="alert-danger">
                    <?= \FW\Session::getError()[0] ?>
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