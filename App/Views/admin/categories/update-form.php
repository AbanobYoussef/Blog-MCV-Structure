  <!-- Content Wrapper. Contains page content  -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
      <ol class="breadcrumb">
        <li>
          <a href="<?php echo url('/admin'); ?>">
            <i class="fa fa-dashboard"></i>
            Home
          </a>
        </li>
        <li>
          <a href="<?php echo url('/admin/categories');?>">
            <i class="fa fa-folder" ></i>
            categories
          </a>
        </li> 
        <li class="active">
          Update category
        </li>
      </ol>
    <div class="box-body" style="background-color: white">
      <h2><?php echo 'Edit '.$Cat->name;?></h2>
       <?php if($errors) {?> 
                <div class="alert alert-danger">
                  <?php echo implode('<br>', $errors); ?> </div>
        <?php }?>
        <div class="f" style="margin:auto; width: 60%;">
            <form action="<?php echo url('/admin/categories/save/' .$Cat->id);?>" method='post' enctype='multipart/form-data'>
             <div class="f1" style="text-align: center;float: left;display: inline-block;">
                <label>Category Name</label><br>
                <input type="text" name="catName" placeholder="Category Name" value="<?php echo $Cat->name;?>">
              </div>
              <div class="f1" style="text-align: center;float: right;display: inline-block;">
                <label>Status</label><br>
                <select name="status">
                  <option value="enabled">Enabled</option>
                  <option value="disabled" <?php echo $Cat->status=='Disabled'?'selected':'';?>>Disabled</option>
                </select>
              </div>
              <br>
              <div style="clear: both;"></div><br>
              <button type="submit"style=" width: 100px; text-align: center;" >update</button>
            </form>
      </div>
    </div>

  </section>
</div>
 

