<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
   <div class="card mb-4">

      <div class="card-header d-flex justify-content-between align-items-center">
         <h4 class="fw-bold py-3 mb-0 pull-left">Contact Requests</h4>
      </div>
      <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                 <thead>
                    <tr>
                       <th>Name</th>
                       <th>Email</th>
                       <th>Mobile</th>
                       <th>Sent On</th>
                       <th>Action</th>
                    </tr>
                 </thead>
                 <tbody>
                    <?php 
                    foreach ($feedbacks as $feedback) {
                      ?>
                      <tr>
                          <td><?php echo $feedback->name; ?></td>
                          <td><?php echo $feedback->email; ?></td>
                          <td><?php echo $feedback->mobile; ?></td>
                          <td><?php echo dateFormat($feedback->created_at); ?></td>
                          <td>
                            <a title="Edit" href="<?php echo route('feedbacks.show', $feedback->id) ?>"><button type="button" class="btn btn-success"><span class="pcoded-micon"><i class='bx bx-edit-alt'></i></span></button></a>
                              <?php echo Form::open(['route' => array('feedbacks.destroy', $feedback->id), 'method' => 'delete','style'=>'display: inline-block;']) ?>
                                  <button title="Delete" type="submit" class="btn btn-danger"><span class="pcoded-micon"><i class='bx bx-trash-alt' ></i></span></button>
                              </form>
                          </td>

                      </tr>
                    <?php } ?>          
                 </tbody>
              </table>
           </div>
           <?php echo $feedbacks->links(); ?>
       </div>
       
    </div>
 </div>