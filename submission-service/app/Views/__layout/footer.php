<footer>

    
</footer>


<!-- MODAL RESET PASSWORD -->

<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resetPasswordLabel">Reset Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form  method="post" id="formResetPassword">
            <div class="form-group">
                <label for="name">New Password</label>
                <input type="password" name="user_password" id="user_password" class="form-control">
            </div>

            <div class="form-group">
                <label for="email">Confirm New Password</label>
                <input type="password" name="user_password2" id="user_password2" class="form-control">
            </div>


            <div class="form-group">
            <button type="submit" class="btn btn-primary float-right">Reset</button>
            </div>

        
        </form>
      </div>
    </div>
  </div>
</div> 

</body>
</html>




<script>
(function($) {

"use strict";

var fullHeight = function() {

	$('.js-fullheight').css('height', $(window).height());
	$(window).resize(function(){
		$('.js-fullheight').css('height', $(window).height());
	});

};
fullHeight();

$('#sidebarCollapse').on('click', function () {
  $('#sidebar').toggleClass('active');
});

})(jQuery);


let popoverTriggerList = [].slice.call( 
            document.querySelectorAll('[data-bs-toggle="popover"]')) 
          
        let popoverList =  
        popoverTriggerList.map(function (popoverTriggerEl) { 
            return new bootstrap.Popover(popoverTriggerEl) 
        }) 


</script> 