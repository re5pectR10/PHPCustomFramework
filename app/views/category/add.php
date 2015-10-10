<?php
use \FW\View\View;
use \FW\Helpers\Common;
use \FW\Session\Session;
use \FW\HTML\Form;
?>
<?= View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">
        <?php if(Session::hasError()): ?>
            <div class="alert alert-danger" role="alert"><?= Session::getError() ?></div>
        <?php endif; ?>
        <div class="row">

            <div class="col-md-12">

                <?= Form::open(array('action' => Common::getBaseURL().$action)) ?>
                <?= Form::text(array('name' => 'name', 'placeholder' => 'Name', 'value' => isset($category) ? $category['name'] : '')) ?>
                <?= Form::submit(array('name' => 'submit', 'value' => $submit)) ?>
                <?= Form::close() ?>
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