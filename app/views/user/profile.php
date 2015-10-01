<?= \FW\View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <?= \FW\Form::open(array('action' => \FW\Common::getBaseURL().'/user')) ?>
                <?= \FW\Form::text(array('name' => 'username', 'value' => $user['username'], ' disabled' => 'true')) ?>
                <?= \FW\Form::text(array('name' => 'email', 'value' => $user['email'])) ?>
                <?= \FW\Form::password(array('name' => 'new_password', 'placeholder' => 'New Password')) ?>
                <?= \FW\Form::password(array('name' => 'password', 'placeholder' => 'Current Password')) ?>
                <?= \FW\Form::submit(array('name' => 'submit', 'value' => 'Change In')) ?>
                <?= \FW\Form::close() ?>
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