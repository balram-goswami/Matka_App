<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <div class="card mb-4">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left"><?php echo $feedback->query_from; ?> Form Requests</h4>
        </div>
        <div class="card-body">
            <?php echo Form::open(['route' => ['apply-now.update', $feedback->id], 'method' => 'put', 'class' => 'md-float-material']);
            ?>
            <div class="row">
                <div class="col-md-12" id="DivIdToPrint">
                    <div class="card">
                        <div class="card-body">
                            <h4>Contact Details</h4>
                            <div class="table-responsive">
                                <?php if($feedback->query_from != 'franchise') { ?>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td><?php echo $feedback->name; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><?php echo $feedback->email; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td><?php echo $feedback->c_code; ?> - <?php echo $feedback->mobile; ?></td>
                                        </tr>
                                        <tr>
                                            <th>City</th>
                                            <td><?php echo $feedback->city; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Your Question About?</th>
                                            <td><?php echo $feedback->course; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Location</th>
                                            <td><?php echo $feedback->location; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Message</th>
                                            <td><?php echo $feedback->message; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Sent ON</th>
                                            <td><?php echo dateFormat($feedback->created_at); ?></td>
                                        </tr>
                                    </tbody>
                                    <?php } 
                            else { ?>
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td><?php echo $feedback->name; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><?php echo $feedback->email; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td><?php echo $feedback->mobile; ?></td>
                                            </tr>
                                            <tr>
                                                <th>City</th>
                                                <td><?php echo $feedback->city; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Investment Type</th>
                                                <td><?php echo $feedback->investment_type; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Business Type</th>
                                                <td><?php echo $feedback->business_type; ?></td>
                                            </tr>
                                            <tr>
                                                <th>How You Know</th>
                                                <td><?php echo $feedback->how_you_know; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Sent ON</th>
                                                <td><?php echo dateFormat($feedback->created_at); ?></td>
                                            </tr>
                                        </tbody>
                                        <?php } ?>
                                    </table>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h4>Send Reply</h4>
                                <div class="input-group row">
                                    <label class="col-form-label" for="subject">Subject</label><br>
                                    <input type="text" name="subject" required="" id="subject"
                                        class="form-control form-control-lg" placeholder="Subject" value="">
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group row">
                                    <label class="col-form-label" for="content">Content</label><br>
                                    <textarea name="content" required="" id="content" class="form-control form-control-lg ckeditor"
                                        placeholder="Content"></textarea>
                                    <span class="md-line"></span>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Send</button>
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
