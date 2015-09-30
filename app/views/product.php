<?= \FW\View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?= \FW\View::getLayoutData('catMenu') ?>

            <div class="col-md-9">

                <div class="col-md-12">
                    <div class="thumbnail">
                        <img src="http://placehold.it/320x150" alt="">
                        <div class="caption">
                            <?php if(\FW\Auth::isAuth()) : ?>
                            <a class="pull-right btn btn-success" href="<?= \FW\Common::getBaseURL() ?>/user/cart/add/<?= $product['id'] ?>">Add to Cart</a>
                            <?php endif; ?>
                            <h4 class="pull-right">Price: <?= $product['price'] ?></h4>
                            <h4><a href="<?= \FW\Common::getBaseURL() ?>/product/<?= $product['id'] ?>"><?= $product['name'] ?></a>
                            </h4>
                            <p class="product-description"><?= $product['description'] ?></p>
                            <div class="ratings">
                                <span class="pull-right">Available: <?= $product['quantity'] ?></span>
                            </div>
                        </div>
                    </div>
                    <h3>Comments</h3>
                    <?php
                    foreach($comments as $c):
                    ?>
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><a href="<?= \FW\Common::getBaseURL() ?>/user/<?= $c['user_id'] ?>"><?= $c['username'] ?></a></h4>
                                <h4><?= $c['posted_on'] ?></h4>
                                <div>
                                    <p><?= $c['content'] ?></p>
                                </div>
                            </div>

                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>

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