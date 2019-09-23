  <!-- Content Wrapper. Contains page content  -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
      <ol class="breadcrumb">
      <li><a href="<?php echo url('/admin'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
      <li class="active">Categories</li>
    </ol>
    <div id="res"></div>
    <?php if($success) {?> 
                <div class="alert alert-success">
                  <?php echo $success; ?>
                </div>
        <?php }?>
    <div class='catHead' style="margin-bottom:-35px">
      <ul class="row list-inline list" style="text-align: center;">
         <li style="width: 10%">#</li>
        <li style="width: 30%">Catigory Name</li>
        <li style="width: 25%">Status</li>
        <li style="width: 20%; margin-left:20px">
          <button type = 'button'
                  class='open-popu btn btn-light' 
                   data-target="<?php echo url('/admin/categories/add');?>"
                  style="width: 100%;display: inline-block;">Add New
          </button>
        </li>
      </ul>
    </div>

<?php foreach ($categories as $cat) { ?>
<div class='catHead' style=" margin-bottom:-35px">
      <ul class="row list-inline list" style="
        text-align: center;">
        <li style="width: 10%"><?php echo $cat->id?></li>
        <li style="width: 30%"><?php echo $cat->name ?></li>
        <li style="width: 25%"><?php echo $cat->status ?></li>
        <li style="width: 20%; margin-left:20px;background-color: #3c8dbc;">
          <button class="btn btn-secondary open-popu"
                  style="width: 48%;display: inline-block;"
                  data-target="<?php echo url('/admin/categories/edit/'. $cat->id);?>">
                  Edit
          </button>
            <button class="btn btn-warning delete"         data-target="<?php echo url('/admin/categories/delete/'. $cat->id);?>" 
                     style="width: 48%;padding: 6px;display: inline-block;color: black"
                     >
              Delete
            </button>
        </li>
      </ul>
    </div>
<?php } ?>

  </section>
</div>
 

