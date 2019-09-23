<div class='block' id='b' style="height: 220%">
<!-- ------------------------------------------->
    <div style="margin:0; width: 100%">
      <h4>
        <b><?php echo $heading ; ?></b>
       </h4>
      <div class="f" >
        <form id="form-modal" action="<?php echo $action ?>">
          <div id="form-results" style="width: 100%"></div>

          <div style="width: 100%">
            <label>First Name</label><br> 
            <input type="text"
                   name="FirstName"
                   placeholder="first_name"
                   value="<?php echo $first_name ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>

          <div style="width: 100%">
            <label>Last Name</label><br> 
            <input type="text"
                   name="LastName"
                   placeholder="Last Name"
                   value="<?php echo $second_name ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>



          <div style="width: 100%">
            <label >Group</label><br>
             <select name="gender"
                     style="display: inline-block;width: 100%"> 
                <option value="male">Male</option>
                <option value="female" <?php echo $gender==='female'?'selected':'' ; ?>>Female</option>
            </select>
          </div>
         

          <div style="width: 100%">
            <label for='users_groups_id'>Group</label><br>
             <select name="users_groups_id" id='pages'        multiple="multiple" 
                    style="display: inline-block;width: 100%">
              <?php foreach ($users_groups as $users_group) { ?>

                <option value="<?php echo $users_group->id; ?>"
                        <?php echo ($users_group->id===$users_group_id)?"selected":""; ?>
                        > 
                   <?php echo $users_group->name; ?>
                          
                </option>
                
              <?php } ?>
            </select>
          </div>



           <div style="width: 100%">
            <label>Email</label><br> 
            <input type="email;"
                   name="email"
                   placeholder="Email"
                   value="<?php echo $email ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>



          <div style="width: 100%">
            <label>BirthDay</label><br> 
            <input type="text;"
                   name="birthday"
                   placeholder="birthday"
                   value="<?php echo $birthday ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>
 

 
          <div style="width: 100%">
            <label>Password</label><br> 
            <input type="password"
                   name="password"
                   placeholder="Password"
                   style="display: inline-block;width: 100%"
                   >
          </div>


          <div style="width: 100%">
            <label>Confirm Password</label><br> 
            <input type="password"
                   name="confirm_password"
                   placeholder="Confirm Password"
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
            <label>image</label><br> 
            <input type="file"
                   name="image" 
                   style="display: inline-block;width: 100%"
                   >
             <?php if($image) {?>
             <img src="<?php echo $image ; ?>" style="width: 100%;" >
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