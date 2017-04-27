<script type="text/javascript">
$(document).ready(function() {
	// set form hidden field as reset code
	$("#reset-code-input").val("<?php echo $reset_code; ?>");
	// set reset form visiable
	$(form_modal_tab.children('li')[3]).removeAttr("style");
	// show the alert dialog
	form_modal.addClass('is-visible');
	// switch to reset code
	reset_selected()
})
</script>
