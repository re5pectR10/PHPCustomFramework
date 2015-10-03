<?= \FW\View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <h1>Your Products</h1>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Bought Price</th>
                        <th>Total Bought Price</th>
                        <th>Bought On</th>
                        <th>Current Price</th>
                        <th>Sell Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($products as $item):
                        ?>
                        <tr>
                            <td><a href="<?= \FW\Common::getBaseURL() ?>/product/<?= $item['id'] ?>"><?= $item['name'] ?></a></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= $item['bought_price'] ?></td>
                            <td class="price"><?= number_format($item['bought_price'] * $item['quantity'], 2) ?></td>
                            <td><?= $item['bought_on'] ?></td>
                            <td><?= $item['current_price'] ?></td>
                            <td>
                                <?= \FW\Form::open(array('action' => \FW\Common::getBaseURL() . '/user/product/' . $item['id'] . '/sell/' . $item['user_product_id'])) ?>
                                <?= \FW\Form::text(array('name' => 'quantity')) ?>
                                <?= \FW\Form::submit(array('value' => 'Sell', 'name' => 'submit', 'class' => 'btn btn-success')) ?>
                                <?= \FW\Form::close() ?>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                    </tbody>
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