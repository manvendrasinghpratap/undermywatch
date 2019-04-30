<?php $utc_str = gmdate("M d Y H:i:s", time()); $utc = strtotime($utc_str); ?>
<script src="{{ asset('assets/js/webtoolkit.base64.js') }}"></script>
<script>
var date1 = new Date();
var url_string = window.location.href; //window.location.href

var urlParams = new URLSearchParams(window.location.search);
var s = date1.getTimezoneOffset();
var str = String(s); 
var res = str.replace("-", "/");
var utc = Base64.encode("<?php echo $utc;?>");  
var d = Base64.encode(res);
if(!urlParams.has('o')){    
    window.location = url_string+"?o="+d+'&_t='+utc;
}
</script>

