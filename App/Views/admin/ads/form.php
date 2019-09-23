 <div class='block' id='b' style="height: 220%">
<!-- ------------------------------------------->
    <div style="margin:auto; width: 50%">
      <h4>
        <b><?php echo $heading ; ?></b>
       </h4> 
      <div class="f"  >
        <form id="form-modal" action="<?php echo $action ?>">
          <div id="form-results" style="width: 100%"></div>
          <div style="width: 100%">
            <label>Name</label><br> 
            <input type="text"
                   name="name"
                   placeholder="Ad Name"
                   value="<?php echo $name ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>

          <div style="width: 100%">
            <label>Ad Url</label><br> 
            <input type="text"
                   name="link"
                   placeholder="Ad Url"
                   value="<?php echo $link ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>


           <div style="width: 100%">
            <label>Status</label><br>
            <select name="status" 
                    style="display: inline-block;width: 100%">
              <option value="enabled">Enabled</option>
              <option value="disabled"  
                      <?php echo $status=='Disabled'?'selected':false;?>
                        >
              Disabled
              </option>
            </select>
          </div>

          <div style="width: 100%">
            <label for='page'>Pages</label><br>
            <select name="page" id='pages' style="display: inline-block;width: 100%">
              <?php foreach ($pages as $page) { ?>

                <option value="<?php echo $page; ?>"
                        <?php echo $page==$ad_page?'selected':''; ?>
                        >
                    <?php echo $page; ?>
                          
                </option>
                
              <?php } ?>
            </select>
          </div>

           <div style="width: 100%">
            <label>Starts At</label><br> 
            <input type="text"
                   name="start_at"
                   placeholder="Starting Ad Date"
                   value="<?php echo $start_at ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>

           <div style="width: 100%">
            <label>Ends At</label><br> 
            <input type="text"
                   name="end_at"
                   placeholder="Ending Ad Date"
                   value="<?php echo $end_at ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>
 
          <div style="width: 100%">
            <label>image</label><br> 
            <input type="file"
                   name="image" 
                   style="display: inline;width: 100%"
                   >
             <?php if($image) {?>
             <img src="<?php echo $image ; ?>" style="width: 50%;" >
             <?php }?>
          </div>



          <button class="submit-btn"><?php echo $butName ; ?></button>
          <div style="float: none"></div>
        </form>
      </div>
      <button class="c"  onclick="$('#b').remove()">Close</button>
    </div>
  
<!-- ------------------------------------------->
</div>