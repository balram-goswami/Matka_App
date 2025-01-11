<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
   <div class="card mb-4">

      <div class="card-header d-flex justify-content-between align-items-center">
         <h4 class="fw-bold py-3 mb-0 pull-left">Contact Requests</h4>
      </div>
      <div class="card-body">
         <?php echo Form::open(['route' => array('feedbacks.update', $feedback->id), 'method' => 'put', 'class' => 'md-float-material']);
         ?>
         
            <div class="row">
               <div class="col-md-12" id="DivIdToPrint">
                  <div class="card">            
                     <div class="card-body">
                        <h4>Contact Details</h4>
                        <div class="table-responsive">
                          <table class="table table-bordered table-striped">
                            <tbody>
                              <tr>
                                <th>Name</th>
                                <td><?php echo $feedback->name ?></td>
                              </tr>
                              <tr>
                                <th>Email</th>
                                <td><?php echo $feedback->email ?></td>
                              </tr>
                              <tr>
                                <th>Mobile</th>
                                <td><?php echo $feedback->mobile ?></td>
                              </tr>
                              <tr>
                                <th>Overall Rating</th>
                                <td><?php echo $feedback->overall_rating ?></td>
                              </tr>
                              <tr>
                                <th>Recommend Matka to friends/family?</th>
                                <td><?php echo $feedback->recommend_service ?></td>
                              </tr>
                              <tr>
                                <th>Staff Name</th>
                                <td><?php echo $feedback->staff_name ?></td>
                              </tr>
                              <tr>
                                <th>Staff Comment</th>
                                <td><?php echo $feedback->staff_comment ?></td>
                              </tr>
                              <tr>
                                <th>Enhance Experience</th>
                                <td><?php echo $feedback->enhance_experience ?></td>
                              </tr>
                              <tr>
                                <th>Did our services meet your requirements?</th>
                                <td><?php echo $feedback->service_requirement ?></td>
                              </tr>
                              <tr>
                                <th>How could we have a better engagement with you?</th>
                                <td><?php echo $feedback->feedback_suggestion ?></td>
                              </tr>
                              <tr>
                                <th>happy for Matka to use your feedback</th>
                                <td><?php echo $feedback->market_activity ?></td>
                              </tr>
                              <tr>
                                <th>Sent ON</th>
                                <td><?php echo dateFormat($feedback->created_at) ?></td>
                              </tr>
                            </tbody>                      
                          </table>
                        </div>
                        <br>
                        <div class="col-md-12">
                          <h4>Send Reply</h4>
                          <div class="input-group row">
                             <label class="col-form-label" for="subject">Subject</label><br>
                             <input type="text" name="subject" required="" id="subject" class="form-control form-control-lg" placeholder="Subject" value="">
                             <span class="md-line"></span>
                          </div>
                          <div class="input-group row">
                             <label class="col-form-label" for="content">Content</label><br>
                             <textarea name="content" required="" id="content" class="form-control form-control-lg ckeditor" placeholder="Content"></textarea>
                             <span class="md-line"></span>
                          </div>
                          <div class="row m-t-30">
                             <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Send</button>
                             </div>
                          </div>
                        </div>
                     </div>
                  </div>
               </div> 
            </div>     
         </form>
      </div>
   </div>
</div>