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
                <?= Form::text(array('name' => 'name', 'placeholder' => 'Name', 'value' => isset($product) ? $product['name'] : Session::oldInput()['name'])) ?>
                <?= Form::textarea(isset($product) ? $product['description'] : Session::oldInput()['description'], array('name' => 'description', 'placeholder' => 'description')) ?>
                <?= Form::text(array('name' => 'quantity', 'placeholder' => 'Quantity', 'value' => isset($product) ? $product['quantity'] : Session::oldInput()['quantity'])) ?>
                <?= Form::text(array('name' => 'price', 'placeholder' => 'price', 'value' => isset($product) ? $product['price'] : Session::oldInput()['price'])) ?>
                <?= Form::select(array('name' => 'category_id', 'required' => 'true'),$categories) ?>
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