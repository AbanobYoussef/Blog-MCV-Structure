<div class='block' id='b' style="height: 220%">
<!-- ------------------------------------------->
    <div>
      <h4>
        <b><?php echo $heading ; ?></b>
      </h4>
      <div class="f">
        <form id="form-modal" action="<?php echo $action ?>">
          <div id="form-results" style="width: 100%"></div>
          <div class="f1">
            <label>Category Name</label><br>
            <input type="text" name="catName"  placeholder="Category Name" value="<?php echo $name ; ?>"><br>
            <button class="submit-btn"><?php echo $butName ; ?></button>
          </div>
          <div class="f1">
            <label>Status</label><br>
            <select name="status">
              <option value="enabled">Enabled</option>
              <option value="disabled"  
                      <?php echo $status=='Disabled'?'selected':false;?>
                        >
              Disabled
              </option>
            </select>
          </div>
          <div style="float: none"></div>
        </form>
      </div>
      <button class="c"  onclick="$('#b').remove()">Close</button>
    </div>
<!-- ------------------------------------------->
</div>