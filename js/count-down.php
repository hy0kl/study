<?php
$time_now = time();
$end_time = $time_now + 3600 * 60 - 45;
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
var start_time = <?php echo $time_now; ?>;
var end_time   = <?php echo $end_time; ?>;
$(document).ready(function(){
    setInterval(function(){
        start_time++;
        count_down();
    }, 1000);
});

function count_down()
{
    var interval = (end_time - start_time) || 0;
    var hour  = Math.floor(interval / 3600);
    var minute= Math.floor(interval % 3600 / 60);
    var second= interval % 60;

    var html = hour + 'Hour ' + minute + 'minute ' + second + 'seconds'; 
    $('#count_down_h_m_s').html(html);
}
</script>
<div id="count_down">count down: <span id="count_down_h_m_s"></span></div>
