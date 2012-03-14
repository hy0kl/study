<?php
/*
    测试 ajax
*/
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function initxmlhttp()
{
    var xmlhttp;
    try
    {
        xmlhttp = new ActiveXobject("Msxml2.XMLHTTP");
    }catch(e)
    {
        xmlhttp = new ActiveXobject("Microsoft.XMLHTTP");
    }catch(E)
    {
        xmlhttp = false;
    }
    if(!xmlhttp && typeof XMLHttpRequest != 'undefined')
    {
        try
        {
            xmlhttp = new XMLHttpRequest();
        }catch(e)
        {
            xmlhttp = false;
        }
    }
    if(!xmlhttp && window.createRequest)
    {
        try
        {
            xmlhttp = window.createRequest();
        }catch(e)
        {
            xmlhttp = false;
        }
    }
    return xmlhttp;
}
//-->
</SCRIPT>