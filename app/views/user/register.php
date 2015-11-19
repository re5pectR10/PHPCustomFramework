<?php
use \FW\View\View;
use \FW\Helpers\Common;
use \FW\Session\Session;
use \FW\HTML\Form;
?>
<?= View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <?= Form::open(array('action' => Common::getBaseURL().'/user/register')) ?>
                <?= Form::text(array('name' => 'username', 'value' => isset(Session::oldInput()['username']) ? Session::oldInput()['username'] : '', 'placeholder' => 'username')) ?>
                <?= Form::password(array('name' => 'password', 'placeholder' => 'password')) ?>
                <?= Form::text(array('name' => 'email', 'placeholder' => 'email', 'value' => isset(Session::oldInput()['email']) ? Session::oldInput()['email'] : '')) ?>
                <?= Form::submit(array('name' => 'submit', 'value' => 'Sign In')) ?>
                <?= Form::close() ?>
                <p class="alert-danger">
                    <?= Session::getError()[0] ?>
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
<?= View::getLayoutData('footer') ?>