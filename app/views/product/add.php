<?= \FW\View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">
        <?php if(\FW\Session::hasError()): ?>
            <div class="alert alert-danger" role="alert"><?= \FW\Session::getError() ?></div>
        <?php endif; ?>
        <div class="row">

            <div class="col-md-12">

                <?= \FW\Form::open(array('action' => \FW\Common::getBaseURL().$action)) ?>
                <?= \FW\Form::text(array('name' => 'name', 'placeholder' => 'Name', 'value' => isset($product) ? $product['name'] : \FW\Session::oldInput()['name'])) ?>
                <?= \FW\Form::textarea(isset($product) ? $product['description'] : \FW\Session::oldInput()['description'], array('name' => 'description', 'placeholder' => 'description')) ?>
                <?= \FW\Form::text(array('name' => 'quantity', 'placeholder' => 'Quantity', 'value' => isset($product) ? $product['quantity'] : \FW\Session::oldInput()['quantity'])) ?>
                <?= \FW\Form::text(array('name' => 'price', 'placeholder' => 'price', 'value' => isset($product) ? $product['price'] : \FW\Session::oldInput()['price'])) ?>
                <?= \FW\Form::select(array('name' => 'category_id', 'required' => 'true'),$categories) ?>
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