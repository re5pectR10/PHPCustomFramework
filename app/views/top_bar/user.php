<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
        <li>
            <a href="<?= \FW\Common::getBaseURL() ?>/user">Profile</a>
        </li>
        <li>
            <a href="<?= \FW\Common::getBaseURL() ?>/user/logout">Logout</a>
        </li>
        <li>
            <a href="<?= \FW\Common::getBaseURL() ?>/user/cart">Cart</a>
        </li>
        <li>
            <a href="<?= \FW\Common::getBaseURL() ?>/user/<?= \FW\Auth::getUserId() ?>/products">Your Products</a>
        </li>
        <?php if($isEditor): ?>
            <li>
                <a href="<?= \FW\Common::getBaseURL() ?>/promotion">Promotions</a>
            </li>
        <?php endif ?>
        <?php if($isAdmin): ?>
            <li>
                <a href="<?= \FW\Common::getBaseURL() ?>/admin/users">Users</a>
            </li>
        <?php endif ?>
    </ul>
</div>