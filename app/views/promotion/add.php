<?= \FW\View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">
        <?php if(\FW\Session::hasError()): ?>
            <div class="alert alert-danger" role="alert"><?= \FW\Session::getError() ?></div>
        <?php endif; ?>
        <div class="row">

            <div class="col-md-12">

                <?= \FW\Form::open(array('action' => \FW\Common::getBaseURL().$action)) ?>
                <?= \FW\Form::text(array('name' => 'discount', 'placeholder' => 'discount', 'value' => \FW\Session::oldInput()['discount'])) ?>
                <?= \FW\Form::datetime(array('name' => 'date', 'placeholder' => 'Exp date. yyyy-dd-mm', 'value' => \FW\Session::oldInput()['date'])) ?>
                <?= \FW\Form::select(array('name' => 'category_id'),$categories) ?>
                <?= \FW\Form::select(array('name' => 'product_id'),$products) ?>
                <?= \FW\Form::submit(array('name' => 'submit', 'value' => $submit)) ?>
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