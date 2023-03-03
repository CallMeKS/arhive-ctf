<?php
/* Smarty version 4.3.0, created on 2022-12-18 08:54:05
  from '/home/healthcheck/web/template/login.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_639ed52dc0da36_28363289',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b16b865f6872ad4c921341e8e90b8d2a34d91615' => 
    array (
      0 => '/home/healthcheck/web/template/login.html',
      1 => 1671123674,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_639ed52dc0da36_28363289 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['error']->value == true) {?>
<div class="alert alert-danger" role="alert">
    !Error
</div>
<?php }?>
<form action="" method="POST" class="login100-form validate-form">
    <span class="login100-form-title p-b-43">
        System Health Check
    </span>
    <div class="wrap-input100 rs1 validate-input" data-validate="Username is required">
        <input class="input100" type="text" name="username">
        <span class="label-input100">Username</span>
    </div>
    <div class="wrap-input100 rs2 validate-input" data-validate="Password is required">
        <input class="input100" type="password" name="password">
        <span class="label-input100">Password</span>
    </div>
    <div class="container-login100-form-btn">
        <button class="login100-form-btn">
            Sign in
        </button>
    </div>
    <div class="text-center w-full p-t-23">
        <a href="#" class="txt1">
            Forgot password?
        </a>
    </div>
</form><?php }
}
