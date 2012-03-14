<?php
class user
{
    private static $count = 0;
    public function __construct()
    {
        self :: $count = self :: $count + 1;
        echo '<BR>$count + 1<BR>';
    }
    public function getCount()
    {
        return self :: $count;
    }
    public function __destruct()
    {
        self :: $count = self :: $count - 1;
        echo '<BR>$count - 1<BR>';
    }
}

$user1 = new user();
$user2 = new user();
$user3 = new user();

echo '<BR>Now here have '.$user1 -> getCount().' users<BR>';

unset($user3);

echo '<BR>Now here have '.$user1 -> getCount().' users<BR>';
?>