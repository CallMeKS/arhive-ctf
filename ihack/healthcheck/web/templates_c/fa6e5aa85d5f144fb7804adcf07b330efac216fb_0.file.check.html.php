<?php
/* Smarty version 4.3.0, created on 2022-12-18 08:54:14
  from '/home/healthcheck/web/template/check.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_639ed536e05816_75552277',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fa6e5aa85d5f144fb7804adcf07b330efac216fb' => 
    array (
      0 => '/home/healthcheck/web/template/check.html',
      1 => 1671126974,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_639ed536e05816_75552277 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['error']->value == true) {?>
<div class="alert alert-danger" role="alert">
    !Error
</div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['success']->value == true) {?>
<div class="alert alert-success" role="alert">
    File has beem uploaded!
</div>
<?php }?>
<div class="row">

  <div class="col-12">
    <span class="login100-form-title p-b-43">
      System Health Check
  </span>
  <a style="float:right" class="btn btn-sm btn-danger" href="index.php?page=eyJjdCI6InhLaUUrRmdUbVBJcTRPOFpCVVdXRUE9PSIsIml2IjoiN2ZmZTA2MzNjZjljMzdhNTdmMzQ3M2Y3OGMzYWQwOGEiLCJzIjoiNmY5ZGE4OTgzOTQ5YmNkOSJ9">Logout</a>
</div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
        
      <div class="card-body">
        <form>
    
    
          <div id="result">
          
          </div>
            
            <div class="form-group">
              <label for="ip">Server</label>
              <select class="form-control" id="ip" >
                <?php echo $_smarty_tpl->tpl_vars['list']->value;?>

              </select>
            
            </div>
          
            <a type="button" href="javascript:void(0)" onclick="submit()" class="btn btn-primary">Submit</a>
          </form>
      </div>
    </div>

  </div>

<div class="col-12 mt-2">

  <div class="card">
    <div class="card-header">
    Upload New List
    </div>
    <div class="card-body">
      <form action="index.php?page=eyJjdCI6InNUM1FmUXgzZlg2cHNicmdFZDNSVXc9PSIsIml2IjoiODQ4ZjMxNmZjMDU3YzRmOWJkZmNmYzE5Y2I3MzU3NDIiLCJzIjoiYzIzZjJiY2Y0NDdhNTNlMiJ9" method="POST" enctype="multipart/form-data">
        <label class="form-label" for="customFile">Choose file (only .txt file allowed)</label>
        <input type="file" class="form-control" name="file"  accept=".txt"/>
        <input class="btn btn-primary" type="submit">
      </form>



    </div>
  </div>



</div>

</div>


<?php echo '<script'; ?>
 src="/assets/enc.js"><?php echo '</script'; ?>
><?php }
}
