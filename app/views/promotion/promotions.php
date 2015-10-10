<?php
use \FW\View\View;
use \FW\Helpers\Common;
use \FW\Session\Session;
?>
<?= View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-12">
                <?php if(Session::hasMessage()): ?>
                    <div class="alert alert-success" role="alert"><?= Session::getMessage() ?></div>
                <?php endif; ?>
                <?php if(Session::hasError()): ?>
                    <div class="alert alert-danger" role="alert"><?= Session::getError() ?></div>
                <?php endif; ?>
                <h1>Promotions</h1>
                <a class="btn btn-success" href="<?= Common::getBaseURL() ?>/promotion/add">Add</a>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Discount</th>
                        <th>Exp Date</th>
                        <th>For</th>
                        <th>Tools</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($promotions as $item):
                        ?>
                        <tr>
                            <td><?= $item['discount'] ?></td>
                            <td><?= $item['exp_date'] ?></td>
                            <td><?= isset($item['product_id']) ? '<a href="'.Common::getBaseURL() .'/product/'.$item['product_id'].'">'. $item['product'] .'</a>' :
                                    (isset($item['category_id']) ? $item['category'] : 'All') ?></td>
                            <td>
                                <a class="btn btn-danger" href="<?= Common::getBaseURL() ?>/promotion/delete/<?= $item['id'] ?>">Remove</a>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                    </tbody>
                </table>
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