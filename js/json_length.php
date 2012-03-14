<?php
$test = array(
    'test' => array(
        'c1',
        'cc1'
    ),
    array('c2', 'cc2'),
    array('c3', 'cc33'),
);
?>
<script language="JavaScript">
<!--
 var testJson = <?php echo json_encode($test); ?>;
 alert(testJson["test"].length);
//-->
</script>