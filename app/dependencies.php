<?php
use FW\DependencyProvider;

DependencyProvider::inject('Controllers\\UsersController', 'name', 'asd\\IUser', 'Controllers\\test', function() {
    DependencyProvider::inject('Controllers\\test', 'e', null, 'Asd\\uuu');
});