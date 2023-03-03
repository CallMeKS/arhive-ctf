<?php
/* Smarty version 4.3.0, created on 2022-12-18 08:54:05
  from '/home/healthcheck/web/template/index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_639ed52dc012e0_56500814',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f2ebfa4d17df41c67904fbf0516708c5407e74c3' => 
    array (
      0 => '/home/healthcheck/web/template/index.html',
      1 => 1671124458,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_639ed52dc012e0_56500814 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">

<head>
    <title>System Health Check</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="assets/animsition.min.css">

    <?php echo '<script'; ?>
 src="/assets/cryptojs-aes.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/assets/cryptojs-aes-format.js"><?php echo '</script'; ?>
>

    <link rel="stylesheet" type="text/css" href="assets/util.css">
    <link rel="stylesheet" type="text/css" href="assets/main.css">

    <meta name="robots" content="noindex, follow">

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-b-160 p-t-50">

                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['page']->value).".html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            </div>
        </div>
    </div>

    <?php echo '<script'; ?>
 src="assets/jquery-3.2.1.min.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="assets/animsition.min.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="assets/popper.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/bootstrap.min.js"><?php echo '</script'; ?>
>


    <?php echo '<script'; ?>
 src="assets/main.js"><?php echo '</script'; ?>
>

</body>

</html><?php }
}
