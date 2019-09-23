<div class='block' id='b' style="height: 220%">
<!-- ------------------------------------------->
    <div>
      <h4>
        <b><?php echo $heading ; ?></b>
       </h4>
      <div class="f">
        <form id="form-modal" action="<?php echo $action ?>">
          <div id="form-results" style="width: 100%"></div>
          <div style="width: 100%">
            <label>Category Name</label><br> 
            <input type="text"
                   name="UGName"  placeholder="Users Group Name" 
                      value="<?php echo $name ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>
          <div style="width: 100%">
            <label for='pages'>Permissions</label><br>
            <select name="pages[]" id='pages' multiple="multiple" style="display: inline-block;width: 100%">
              <?php foreach ($pages as $page) { ?>

                <option value="<?php echo $page; ?>"
                        <?php echo in_array($page, $userPages)?'selected':''; ?>
                        >
                    <?php echo $page; ?>
                          
                </option>
                
              <?php } ?>
            </select>
          </div>
          <button class="submit-btn"><?php echo $butName ; ?></button>
          <div style="float: none"></div>
        </form>
      </div>
      <button class="c"  onclick="$('#b').remove()">Close</button>
    </div>
<!-- ------------------------------------------->
</div>