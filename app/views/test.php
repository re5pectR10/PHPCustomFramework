<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body><?php //var_dump(get_defined_vars()); ?>
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