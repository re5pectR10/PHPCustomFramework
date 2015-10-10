<?php
use \FW\View\View;
use \FW\Helpers\Common;
use \FW\Session\Session;
use \FW\HTML\Form;
use \FW\Security\Auth;
?>
<?= View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?= View::getLayoutData('catMenu') ?>

            <div class="col-md-9">
                <?php if(Session::hasMessage()): ?>
                    <div class="alert alert-success" role="alert"><?= Session::getMessage() ?></div>
                <?php endif; ?>
                <?php if(Session::hasError()): ?>
                    <div class="alert alert-danger" role="alert"><?= Session::getError() ?></div>
                <?php endif; ?>
                <div class="col-md-12">
                    <div class="thumbnail">
                        <img src="https://hivemc.com/media/images/game_sg_placeholder.jpg" alt="">
                        <div class="caption">
                            <?php if(Auth::isAuth()) : ?>
                            <a class="pull-right btn btn-success" href="<?= Common::getBaseURL() ?>/user/cart/add/<?= $product['id'] ?>">Add to Cart</a>
                            <?php endif; ?>
                            <?php if (isset($product['promotion_price'])) : ?>
                                <h2 class="pull-right"><?= $product['promotion_price'] ?></h2>
                            <?php endif; ?>
                            <h4 class="<?= isset($product['promotion_price']) ? 'strike' : '' ?> pull-right"><?= $product['price'] ?></h4>
                            <h4><a href="<?= Common::getBaseURL() ?>/product/<?= $product['id'] ?>"><?= $product['name'] ?></a>
                            </h4>
                            <?php if($isEditor): ?>
                                <a href="<?= Common::getBaseURL() ?>/product/edit/<?= $product['id'] ?>" class="btn btn-primary">Edit</a>
                                <a href="<?= Common::getBaseURL() ?>/product/delete/<?= $product['id'] ?>" class="btn btn-danger">Delete</a>
                            <?php endif ?>
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
                                <h4><a href="<?= Common::getBaseURL() ?>/user/<?= $c['user_id'] ?>"><?= $c['username'] ?></a></h4>
                                <h4><?= $c['posted_on'] ?></h4>
                                <div>
                                    <p><?= $c['content'] ?></p>
                                </div>
                            </div>
                            <?php if(Auth::getUserId() == $c['user_id'] || $isAdmin): ?>
                                <a href="<?= Common::getBaseURL() ?>/comment/delete/<?= $c['id'] ?>" class="btn btn-danger">Delete</a>
                            <?php endif ?>
                        </div>
                    <?php
                    endforeach;
                    ?>
                    <?php if (Auth::isAuth()) : ?>
                        <div class="thumbnail">
                            <div class="caption">
                                <?= Form::open(array('action' => Common::getBaseURL().'/product/' .$product['id'] . '/add/comment')) ?>
                                <?= Form::textarea('', array('name' => 'content', 'placeholder' => 'Write here', 'rows' => '4', 'cols' => '100')) ?>
                                <?= Form::submit(array('name' => 'submit', 'value' => 'Send', 'class' => 'btn btn-success')) ?>
                                <?= Form::close() ?>
                            </div>
                        </div>
                    <?php endif; ?>
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