<?php
if ($_POST)
{
    print_r($_POST);
}
?>
<!-- readonly="readonly" -->
<form method="post" action="">
    <select name="test"  disabled>
    <option value="please">Please Select</option>
    <option value="test" selected>Test readonly</option>
    <option value="check">Have difference</option>
</select>
<br />
<input type="text" name="man" value="I am man" readonly="readonly">
<br />
<input type="checkbox" name="test_checkbox" readonly> Test checkbox and Readonly.
<br />
<input type="checkbox" name="disabled_checkbox" disabled> Test checkbox and Readonly.
<br />
<input type="checkbox" name="test[]" value="Hello.">I am test checkbox 1.<br />
<input type="checkbox" name="test[]" value="Word">I am test checkbox 2.<br />
<input type="checkbox" name="test[]" value="BSD">I am test checkbox 3.<br />
<input type="checkbox" name="test[]" value="Welcome">I am test checkbox 4.<br />
<input type="submit">
</form>