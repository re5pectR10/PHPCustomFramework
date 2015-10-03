<?php
/**
 * @var Controllers\Admin\Index $model
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body><?php echo $model->aeee; ?>
<?php
echo \FW\Form::open(array('action'=>\FW\Common::getBaseURL().'/users/test/asd', 'name'=>'asd')) ;
echo \FW\Form::text(array('name' => 'a'));
echo \FW\Form::text(array('name' => 'paka'));
echo \FW\Form::file();
?>
    <input type="submit">
</form>
</body>
</html>