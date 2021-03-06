<?php
use \FW\View\View;
use \FW\Helpers\Common;
use \FW\Session\Session;
?>
<?= View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?= View::getLayoutData('catMenu') ?>
            <?php if($isEditor): ?>
                <a href="<?= Common::getBaseURL() ?>/product/add" class="btn btn-success">Add Product</a>
            <?php endif ?>
            <div class="col-md-9">
                <?php if(Session::hasMessage()): ?>
                    <div class="alert alert-success" role="alert"><?= Session::getMessage() ?></div>
                <?php endif; ?>
                <?php if(Session::hasError()): ?>
                    <div class="alert alert-danger" role="alert"><?= Session::getError() ?></div>
                <?php endif; ?>

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="https://hivemc.com/media/images/game_sg_placeholder.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="https://hivemc.com/media/images/game_sg_placeholder.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="https://hivemc.com/media/images/game_sg_placeholder.jpg" alt="">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <?php
                    foreach($products as $p):
                    ?>
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="https://hivemc.com/media/images/game_sg_placeholder.jpg" alt="">
                            <div class="caption">
                                <?php if (isset($p['promotion_price'])) : ?>
                                    <h2 class="pull-right"><?= $p['promotion_price'] ?></h2>
                                <?php endif; ?>
                                <h4 class="<?= isset($p['promotion_price']) ? 'strike' : '' ?> pull-right"><?= $p['price'] ?></h4>
                                <h4><a href="<?= Common::getBaseURL() ?>/product/<?= $p['id'] ?>"><?= $p['name'] ?></a>
                                </h4>
                                <div>

                                </div>
                                <p class="product-description"><?= $p['description'] ?></p>
                            </div>
                            <div class="ratings">
                                <span class=""><?= $p['comments_count'] ?> comments</span>
                                <span class="pull-right">Available: <?= $p['quantity'] ?></span>
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
<?= View::getLayoutData('footer') ?>