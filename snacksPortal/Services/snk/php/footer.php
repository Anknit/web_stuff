<?php
?>
        <div class='container'>
            <div class="col-md-8 col-md-offset-2 text-center" data-ng-controller="footerController">
                <p class="text-danger">Note: Order for the day will be finalised at 11.30 a.m. Don't miss the chance to order sancks of your choice</p>
                <p class="text-center">For any Query or feedback &nbsp;
                    <button type="button" data-toggle="modal" data-target="#feedbackSnacks" class="btn btn-success">Write Here</button>
                    <div class="modal fade" id="feedbackSnacks" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Snacks Feedback</h4>
                          </div>
                          <div class="modal-body">
                            <textarea id="feedback-text" data-ng-model="feedback.text" ng-init="" maxlength="250" required class="form-control" rows="5" placeholder="What you want to write today" style="resize:none"></textarea>
                              <p class="text-right"><strong>{{ 250 - feedback.text.length}}</strong>&nbsp;characters remaining</p>
                              <p class="text-center"><span class="alert invisible alert-success" id="feedback-message"></span></p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-ng-click="submitFeedback()">Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>                
                </p> 
            </div>
            <div class='col-md-12 text-center'>
                <p class='center-block text-primary text-center'>&#169; <?php echo COPYRIGHT ;?></p>
            </div>
            <div id="overlayBlock" class="hide"></div>
        </div>
        <footer>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
            <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular-route.min.js"></script>

            <script type="text/javascript" src="./js/appmodule.js"></script>
            <script type="text/javascript" src="./controller/home-controller.js"></script>
            <script type="text/javascript" src="./controller/footer-controller.js"></script>
            <script type="text/javascript" src="./controller/next-day-controller.js"></script>
            <script type="text/javascript" src="./controller/change-password-controller.js"></script>
        </footer>
    </body>
</html>