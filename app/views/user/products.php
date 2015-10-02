<?= \FW\View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <h1>Your Cart</h1>
                <h2>Your Cash: <?= $user_cash ?></h2>
                <a class="btn btn-success" href="<?= \FW\Common::getBaseURL() ?>/user/cart/buy">Buy</a>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Bought Price</th>
                        <th>Quantity To Sell</th>
                        <th>Sell Price</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($products as $item):
                        ?>
                        <tr>
                            <td><a href="<?= \FW\Common::getBaseURL() ?>/product/<?= $item['id'] ?>"><?= $item['name'] ?></a></td>
                            <td>
                                <?= \FW\Form::open(array('action' => \FW\Common::getBaseURL() . '/user/cart/product/' . $item['id'] . '/quantity')) ?>
                                <?= \FW\Form::text(array('value' => $item['cart_quantity'], 'name' => 'quantity')) ?>
                                <?= \FW\Form::submit(array('value' => 'Change', 'name' => 'submit')) ?>
                                <?= \FW\Form::close() ?>
                            </td>
                            <td class="price"><?= $item['price'] * $item['cart_quantity'] ?></td>
                            <td>
                                <a class="btn btn-danger" href="<?= \FW\Common::getBaseURL() ?>/user/cart/product/<?= $item['id'] ?>/remove">Remove</a>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                    </tbody>
                    <tfoot>
                    <tr class="summary">
                        <td></td>
                        <td></td>
                        <td id="total_price"></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
                <p class="alert-danger"><?= \FW\Session::hasError() ? \FW\Session::getError() : '' ?></p>
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