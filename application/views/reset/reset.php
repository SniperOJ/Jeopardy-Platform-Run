<script type="text/javascript">
    // set form hidden field as reset code
    $("#reset-code-input").value(<?php echo $reset_code; ?>);
    // show this form
    $(form_modal_tab.children('li')[3]).removeAttr("style");
</script>
