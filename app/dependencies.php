<?php
use FW\DependencyProvider;

DependencyProvider::inject('Controllers\CategoryController', 'category', null, 'Models\Category');
DependencyProvider::inject('Controllers\CategoryController', 'product', null, 'Models\Product');
DependencyProvider::inject('Controllers\CategoryController', 'promotion', null, 'Models\Promotion');

DependencyProvider::inject('Controllers\CartController', 'user', null, 'Models\User');
DependencyProvider::inject('Controllers\CartController', 'product', null, 'Models\Product');
DependencyProvider::inject('Controllers\CartController', 'promotion', null, 'Models\Promotion');

DependencyProvider::inject('Controllers\AdminController', 'user', null, 'Models\User');

DependencyProvider::inject('Controllers\CommentController', 'comment', null, 'Models\Comment');

DependencyProvider::inject('Controllers\ProductController', 'category', null, 'Models\Category');
DependencyProvider::inject('Controllers\ProductController', 'product', null, 'Models\Product');
DependencyProvider::inject('Controllers\ProductController', 'promotion', null, 'Models\Promotion');
DependencyProvider::inject('Controllers\ProductController', 'comment', null, 'Models\Comment');

DependencyProvider::inject('Controllers\PromotionController', 'category', null, 'Models\Category');
DependencyProvider::inject('Controllers\PromotionController', 'product', null, 'Models\Product');
DependencyProvider::inject('Controllers\PromotionController', 'promotion', null, 'Models\Promotion');

DependencyProvider::inject('Controllers\UserController', 'product', null, 'Models\Product');
DependencyProvider::inject('Controllers\UserController', 'user', null, 'Models\User');