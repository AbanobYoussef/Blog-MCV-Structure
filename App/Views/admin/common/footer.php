 <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.4.18
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
        reserved.
  </footer>
<!--Start Block Form --> 
<div class='block' id='form' style="height: 220%">
<!-- ------------------------------------------->
    <div style="margin:0; width: 100%">
      <h4>
        <b><?php echo "Edit User Profile" ?></b>
       </h4>
      <div class="f" >
        <form id="form-modal" action="<?php echo url('/admin/profile/update') ?>">
          <div id="form-results" style="width: 100%"></div>

          <div style="width: 100%">
            <label>First Name</label><br> 
            <input type="text"
                   name="FirstName"
                   placeholder="first_name"
                   value="<?php echo $user->first_name ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>

          <div style="width: 100%">
            <label>Last Name</label><br> 
            <input type="text"
                   name="LastName"
                   placeholder="Last Name"
                   value="<?php echo $user->second_name ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>



          <div style="width: 100%">
            <label >Group</label><br>
             <select name="gender"
                     style="display: inline-block;width: 100%"> 
                <option value="male">Male</option>
                <option value="female" <?php echo $user->gender==='female'?'selected':'' ; ?>>Female</option>
            </select>
          </div>
         

           <div style="width: 100%">
            <label>Email</label><br> 
            <input type="email;"
                   name="email"
                   placeholder="Email"
                   value="<?php echo $user->email ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>



          <div style="width: 100%">
            <label>BirthDay</label><br> 
            <input type="text;"
                   name="birthday"
                   placeholder="birthday"
                   value="<?php echo $user->birthday ; ?>"
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
            <label>Status</label><br>
            <select name="status" 
                    style="display: inline-block;width: 100%">
              <option value="enabled">Enabled</option>
              <option value="disabled"  
                      <?php echo $user->status=='Disabled'?'selected':false;?>
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
             <?php if($user->image) {?>
             <img src="<?php echo assets('images/'.$user->image) ; ?>" style="width: 50%;" >
             <?php }?>
          </div>





          <button class="submit-btn">Edit</button>
          <div style="float: none"></div>
        </form>
      </div>
      <button class="c"  onclick="$('#form').hide()">Close</button>
    </div>
<!-- ------------------------------------------->
</div>
<!-- End Block Form -->
    </div>
    <script src="<?php echo assets('admin/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo assets('admin/bower_components/jquery-ui/jquery-ui.min.js'); ?>"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo assets('admin/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
    <!-- Morris.js charts -->
    <script src="<?php echo assets('admin/bower_components/raphael/raphael.min.js'); ?>"></script>
    <script src="<?php echo assets('admin/bower_components/morris.js/morris.min.js'); ?>"></script>
    <!-- Sparkline -->
    <script src="<?php echo assets('admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js'); ?>"></script>
    <!-- jvectormap -->
    <script src="<?php echo assets('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
    <script src="<?php echo assets('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo assets('admin/bower_components/jquery-knob/dist/jquery.knob.min.js'); ?>"></script>
    <!-- daterangepicker -->
    <script src="<?php echo assets('admin/bower_components/moment/min/moment.min.js'); ?>"></script>
    <script src="<?php echo assets('admin/bower_components/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
    <!-- datepicker -->
    <script src="<?php echo assets('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo assets('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
    <!-- Slimscroll -->
    <script src="<?php echo assets('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo assets('admin/bower_components/fastclick/lib/fastclick.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo assets('admin/dist/js/adminlte.min.js'); ?>"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo assets('admin/dist/js/pages/dashboard.js'); ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo assets('admin/dist/js/demo.js'); ?>"></script>
    <script src="<?php echo assets('admin/js/ckeditor.js'); ?>"></script>
    <script>
      $(function(){

        //1-get the active link 
        var currentUrl=window.location.href;
        var segment=currentUrl.split('/').pop(); 
        $('#'+segment+'-link').addClass('active');
        $('.open-popu').on('click',function(){
          btu=$(this);
          url=btu.data('target');
          $.ajax({
            url:url,
            type:'POST',
            success:function(html)
              {
               $('body').append(html);
                document.getElementById('b').style.display = 'block';
              }
          });
        });

        $(document).on('click','.submit-btn',function(e){
            btn=$(this);
            e.preventDefault();
            form=btn.parents('#form-modal');
 
            if(typeof(editorData)!=="undefined")
            {
                form.find('#details').val(editorData);
            }
            url= form.attr('action');
            data= new FormData(form[0]);
            formRes=form.find('#form-results');
            $.ajax({
                url:url,
                data:data,
                type:'POST',
                dataType:'json',
                beforeSend:function (){
                     formRes.removeClass().addClass('alert alert-info').html('Logging....');
                },
                success : function (results){
                    if(results.errors)
                        {
                            formRes.removeClass().addClass("alert alert-danger").html(results.errors);
                        }
                    else if(results.success)
                    {

                        formRes.removeClass().addClass("alert alert-danger").html(results.errors);
                    }
                    if(results.redirectTo)
                    {
                       window.location.href=results.redirectTo;
                    }
                },
                 cache:false,
                 processData:false,
                 contentType:false,


            });
        });


        $('.delete').on('click',function(e){
            e.preventDefault();

            var c=confirm('Are You Sure');
            btu =$(this);
            if(c=== true)
            {
                //start deleting
                $.ajax({
                    url:btu.data('target'),
                    type:'POST',
                    dataType:'json',
                    beforeSend:function (){

                        $('#res').removeClass().addClass("alert alert-info").html('Deleting..');
                    },
                    success : function (results){
                       
                       if(results.success)
                       {
                            $('#res').removeClass().addClass("alert alert-success").html(results.success);

                            row=btu.parents('.catHead');
                            row.fadeOut(function(){
                                row.remove();
                            });
                       }

                    },

                }); 

            }
            else
            {

            }

        });


      });
    </script>
   
  </body>
</html>


 