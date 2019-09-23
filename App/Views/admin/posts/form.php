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
            <label>Post Title</label><br> 
            <input type="text"
                   name="title"
                   placeholder="Title"
                   value="<?php echo $title ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>

           <div class="edit" style="width: 100%">
            <label>Details</label><br> 
            <textarea  name="details" id='details' cols="30" rows="10">
              <?php echo $details; ?>
            </textarea>
          </div>



          <div style="width: 100%">
            <label>Tags</label><br> 
            <input type="text;"
                   name="tags"
                   placeholder="Email"
                   value="<?php echo $tags ; ?>"
                   style="display: inline-block;width: 100%"
                   >
          </div>
         

          <div style="width: 100%">
            <label for='category_id'>Group</label><br>
             <select name="category_id" id='pages'        multiple="multiple" 
                    style="display: inline-block;width: 100%">
              <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category->id; ?>"
                        <?php echo ($category->id===$category_id)?"selected":""; ?>
                        > 
                   <?php echo $category->name; ?> 
                </option>
              <?php } ?>
            </select>
          </div>




            <div style="width: 100%">
            <label for='related_posts'>Related Posts</label><br>
             <select name="related_posts[]" id='pages'        multiple="multiple" 
                    style="display: inline-block;width: 100%">
              <?php foreach ($posts as $post) 
              { 
                     if($post->id==$id) 
                      {
                        continue;
                      }?>
                <option value="<?php echo $post->id; ?>"
                        <?php echo in_array($post->id, $related_posts)?"selected":""; ?>
                        > 
                   <?php echo $post->title; ?> 
                </option>
              <?php } ?>
            </select>
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
    <script>
      ClassicEditor
          .create( document.querySelector( '#details' ) )
          .then( newEditor => {
              editor = newEditor;
          } )
          .catch( error => {
              console.error( error );
          } );

      // Assuming there is a <button id="submit">Submit</button> in your application.
      document.querySelector( '.submit-btn' ).addEventListener( 'click', () => {
          editorData = editor.getData();

        // ...
    } );
  </script>
  <style >
    .block  div .ck-editor__main
    {
      left:-50%;
      width:200%;
      margin: 0;
      padding: 0;
    }
  </style>
<!-- ------------------------------------------->
</div>