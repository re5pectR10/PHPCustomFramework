<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body><?php //var_dump(get_defined_vars()); ?>
<?php echo \FW\Form::open(array('action'=>\FW\Common::getBaseURL().'/users/test/asd')) ?>
    <input type="text" name="a">
    <input type="text" name="paka">
    <input type="submit">
</form>
</body>
</html>