<div class="modal fade" id="editModal<?php echo $value->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Edit the Events Details</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&#215;</span>
        </button>
      </div>
	  <form action="" method="POST"  enctype="multipart/form-data">
      <div class="modal-body">
         
	      <div class="form-row">
              <div class="form-group col-md-6">
			      <input type="hidden" name="id" value="<?php echo $value->id;?>"/>
                  <label>Title</label>
                  <input type="text" name="title" id="Big" value="<?php echo $value->title;?>" class="form-control">
              </div>
			  <div class="form-group col-md-6">
                  <label>Date</label>
                  <input type="text" name="date" id="Small" value="<?php echo $value->date;?>" class="form-control">
              </div>
			  <div class="form-group col-md-6">
                  <label>Venue</label>
                  <input type="text" name="venue" id="Small" value="<?php echo $value->venue;?>" class="form-control">
              </div>
			  <div class="form-group col-md-6">
                  <label>Description</label>
                  <input type="text" name="desp" id="Small" value="<?php echo $value->description;?>" class="form-control">
              </div>
	
	</div>
	          
	 
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <button name="update" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span> Update</button>
      </div>
	  </form>
	  
    </div>
  </div>
</div>