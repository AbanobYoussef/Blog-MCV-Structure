  <!-- Content Wrapper. Contains page content  -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
      <ol class="breadcrumb">
      <li><a href="<?php echo url('/admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Ads</li>
    </ol>
    <div id="res"></div>
    <?php if($success) {?> 
                <div class="alert alert-success">
                  <?php echo $success; ?>
        <?php }?>
    <div  style="margin-bottom:-35px ;width: 100%; text-align: center;">
       <table style="text-align: center;"> 
         <th style="width: 5% ; border:2px #3c8dbc solid">#</th>
        <th style="width: 20%; border:2px #3c8dbc solid;text-align: center;">Name</th>
        <th style="width: 20%; border:2px #3c8dbc solid;text-align: center;">Url</th>
        <th style="width: 20%; border:2px #3c8dbc solid;text-align: center;">Status</th>
        <th style="width: 20%; border:2px #3c8dbc solid;text-align: center;">Starts At</th>
        <th style="width: 20%; border:2px #3c8dbc solid;text-align: center;">Ends At</th>
        <th style="width: 20%; border:2px #3c8dbc solid;text-align: center;">Created</th>
        <th style="width: 20%; border:2px #3c8dbc solid;text-align: center;">Action</th>
        <th style="width: 10%; margin-left:20px">
          <button type = 'button'
                  class='open-popu btn btn-light' 
                   data-target="<?php echo url('/admin/ads/add');?>"
                  style="width: 100%;display: inline-block;">Add New
          </button>
        </th>


        <?php foreach ($ads as $ad) { ?>
    <tr class='catHead'>
        <td style="width: 5%; border:2px #3c8dbc solid;"><?php echo $ad->id ?></td>
        <td style="width: 20%; border:2px #3c8dbc solid;"    >
          <img src="<?php echo assets('images/'.$ad->image ); ?>" 
               style="width: 30px;height: 30px;border-radius: 50%;"
                >
          <span><?php  echo $ad->name;?></span>
        </td>
        <td style="width: 20%; border:2px #3c8dbc solid;"><?php echo $ad->link ?></td>
        <td style="width: 20%; border:2px #3c8dbc solid;"><?php echo ucfirst($ad->status) ?></td>
        <td style="width: 20%; border:2px #3c8dbc solid;"><?php echo date('d-m-Y',$ad->start_at); ?></td>
         <td style="width: 20%; border:2px #3c8dbc solid;"><?php echo date('d-m-Y',$ad->end_at); ?></td>
         <td style="width: 20%; border:2px #3c8dbc solid;"><?php echo date('d-m-Y',$ad->created); ?></td>
        <td style="width: 10%; margin-left:20px; border:2px #3c8dbc solid">
          <button class="btn btn-secondary open-popu"
                  style="width: 100%;display: block;"
                  data-target="<?php echo url('/admin/ads/edit/'. $ad->id);?>">
                  Edit
          </button>
           <button class="btn btn-warning delete"         data-target="<?php echo url('/admin/ads/delete/'. $ad->id);?>" 
                     style="width: 100%;padding: 6px;display: block;color: lightgray"
                     >
              Delete
          </button>
        </td>
      </tr>
<?php } ?>



      </table>
       
    </div>



  </section>
</div>
 

