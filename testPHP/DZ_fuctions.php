<?php
/*
    DZ 常用的库函数
    2007-9-28
*/

explode();
/*
array explode ( string separator, string string [, int limit] )


此函数返回由字符串组成的数组，每个元素都是 string 的一个子串，它们被字符串 separator 作为边界点分割出来。如果设置了 limit 参数，则返回的数组包含最多 limit 个元素，而最后那个元素将包含 string 的剩余部分。 

如果 separator 为空字符串（""），explode() 将返回 FALSE。如果 separator 所包含的值在 string 中找不到，那么 explode() 将返回包含 string 单个元素的数组。 

如果 limit 参数是负数，则返回除了最后的 limit 个元素外的所有元素。此特性是 PHP 5.1.0 中新增的。 

由于历史原因，虽然 implode() 可以接收两种参数顺序，但是 explode() 不行。你必须保证 separator 参数在 string 参数之前才行。 

注: 参数 limit 是在 PHP 4.0.1 中加入的。 
*/

preg_match();
/*
int preg_match ( string pattern, string subject [, array matches [, int flags]] )


在 subject 字符串中搜索与 pattern 给出的正则表达式相匹配的内容。 

如果提供了 matches，则其会被搜索的结果所填充。$matches[0] 将包含与整个模式匹配的文本，$matches[1] 将包含与第一个捕获的括号中的子模式所匹配的文本，以此类推。 

flags 可以是下列标记： 


PREG_OFFSET_CAPTURE
如果设定本标记，对每个出现的匹配结果也同时返回其附属的字符串偏移量。注意这改变了返回的数组的值，使其中的每个单元也是一个数组，其中第一项为匹配字符串，第二项为其偏移量。本标记自 PHP 4.3.0 起可用。 

flags 参数自 PHP 4.3.0 起可用。 
*/

preg_quote();
/*
string preg_quote ( string str [, string delimiter] )

preg_quote() 以 str 为参数并给其中每个属于正则表达式语法的字符前面加上一个反斜线。如果你需要以动态生成的字符串作为模式去匹配则可以用此函数转义其中可能包含的特殊字符。 

如果提供了可选参数 delimiter，该字符也将被转义。可以用来转义 PCRE 函数所需要的定界符，最常用的定界符是斜线 /。 

正则表达式的特殊字符包括：. \\ + * ? [ ^ ] $ ( ) { } = ! < > | :。
*/

substr();
/*
substr -- Return part of a string
Description
string substr ( string string, int start [, int length] )

substr() returns the portion of string specified by the start and length parameters. 

If start is non-negative, the returned string will start at the start'th position in string, counting from zero. For instance, in the string 'abcdef', the character at position 0 is 'a', the character at position 2 is 'c', and so forth.

*/

microtime();
/*
mixed microtime ( [bool get_as_float] )


microtime() 当前 Unix 时间戳以及微秒数。本函数仅在支持 gettimeofday() 系统调用的操作系统下可用。 

如果调用时不带可选参数，本函数以 "msec sec" 的格式返回一个字符串，其中 sec 是自 Unix 纪元（0:00:00 January 1, 1970 GMT）起到现在的秒数，msec 是微秒部分。字符串的两部分都是以秒为单位返回的。 

如果给出了 get_as_float 参数并且其值等价于 TRUE，microtime() 将返回一个浮点数。 

注: get_as_float 参数是 PHP 5.0.0 新加的。
*/

time();
/*
int time ( void )

返回自从 Unix 纪元（格林威治时间 1970 年 1 月 1 日 00:00:00）到当前时间的秒数。
*/

gmdate();
/*
string gmdate ( string format [, int timestamp] )

同 date() 函数完全一样，只除了返回的时间是格林威治标准时（GMT）。
*/

strlen();
/*
int strlen ( string string )

Returns the length of the given string. 
*/

md5();
/*
string md5 ( string str [, bool raw_output] )


Calculates the MD5 hash of str using the RSA Data Security, Inc. MD5 Message-Digest Algorithm, and returns that hash. The hash is a 32-character hexadecimal number. If the optional raw_output is set to TRUE, then the md5 digest is instead returned in raw binary format with a length of 16. 

注: The optional raw_output parameter was added in PHP 5.0.0 and defaults to FALSE 
*/

base64_decode();
/*
string base64_decode ( string encoded_data )

base64_decode() 对 encoded_data 进行解码，返回原始数据，失败则返回 FALSE。返回的数据可能是二进制的。
*/

ord();
/*
int ord ( string string )

Returns the ASCII value of the first character of string. This function complements chr(). 
*/

str_replace();
/*
mixed str_replace ( mixed search, mixed replace, mixed subject [, int &count] )

This function returns a string or an array with all occurrences of search in subject replaced with the given replace value. If you don't need fancy replacing rules (like regular expressions), you should always use this function instead of ereg_replace() or preg_replace(). 

As of PHP 4.0.5, every parameter in str_replace() can be an array. 
*/

setcookie();
/*
bool setcookie ( string name [, string value [, int expire [, string path [, string domain [, bool secure]]]]] )

setcookie() 定义一个和其余的 HTTP 标头一起发送的 cookie。和其它标头一样，cookie 必须在脚本的任何其它输出之前发送（这是协议限制）。这需要将本函数的调用放到任何输出之前，包括 <html> 和 <head> 标签以及任何空格。如果在调用 setcookie() 之前有任何输出，本函数将失败并返回 FALSE。如果 setcookie() 函数成功运行，将返回 TRUE。这并不说明用户是否接受了 cookie。 

注: 自 PHP 4 起，可以用输出缓存来在调用本函数前输出内容，代价是把所有向浏览器的输出都缓存在服务器，直到下命令发送它们。可以在代码中使用 ob_start() 及 ob_end_flush() 来实现这样的功能，或者通过修改 php.ini 中的 output_buffering 配置选项来实现，也可以通过修改服务器配置文件来实现。 

除了 name 外，其它所有参数都是可选的。可以用空字符串（""）替换某参数以跳过该参数。因为参数 expire 是整型，不能用空字符串掉过，可以用零（0）来代替 。
*/

empty();
/*
bool empty ( mixed var )

如果 var 是非空或非零的值，则 empty() 返回 FALSE。换句话说，""、0、"0"、NULL、FALSE、array()、var $var; 以及没有任何属性的对象都将被认为是空的，如果 var 为空，则返回 TRUE。 

除了当变量没有置值时不产生警告之外，empty() 是 (boolean) var 的反义词。参见转换为布尔值获取更多信息.
*/

strtolower();
/*
string strtolower ( string str )

Returns string with all alphabetic characters converted to lowercase. 

Note that 'alphabetic' is determined by the current locale. This means that in i.e. the default "C" locale, characters such as umlaut-A ("A) will not be converted.
*/

in_array();
/*
bool in_array ( mixed needle, array haystack [, bool strict] )

在 haystack 中搜索 needle，如果找到则返回 TRUE，否则返回 FALSE。 

如果第三个参数 strict 的值为 TRUE 则 in_array() 函数还会检查 needle 的类型是否和 haystack 中的相同。 

注: 如果 needle 是字符串，则比较是区分大小写的。 

注: 在 PHP 版本 4.2.0 之前，needle 不允许是一个数组。
*/

function_exists();
/*
bool function_exists ( string function_name )

Checks the list of defined functions, both built-in (internal) and user-defined, for function_name. 如果成功则返回 TRUE，失败则返回 FALSE。
*/

mysql_unbuffered_query();
/*
resource mysql_unbuffered_query ( string query [, resource link_identifier] )

mysql_unbuffered_query() 向 MySQL 发送一条 SQL 查询 query，但不像 mysql_query() 那样自动获取并缓存结果集。一方面，这在处理很大的结果集时会节省可观的内存。另一方面，可以在获取第一行后立即对结果集进行操作，而不用等到整个 SQL 语句都执行完毕。当使用多个数据库连接时，必须指定可选参数 link_identifier。 

注: mysql_unbuffered_query() 的好处是有代价的：在 mysql_unbuffered_query() 返回的结果集之上不能使用 mysql_num_rows() 和 mysql_data_seek()。此外在向 MySQL 发送一条新的 SQL 查询之前，必须提取掉所有未缓存的 SQL 查询所产生的结果行。
*/

mysql_affected_rows();
/*
int mysql_affected_rows ( [resource link_identifier] )

取得最近一次与 link_identifier 关联的 INSERT，UPDATE 或 DELETE 查询所影响的记录行数。 

参数

link_identifier
MySQL 的连接标识符。如果没有指定，默认使用最后被 mysql_connect() 打开的连接。如果没有找到该连接，函数会尝试调用 mysql_connect() 建立连接并使用它。如果发生意外，没有找到连接或无法建立连接，系统发出 E_WARNING 级别的警告信息。

返回值
执行成功则返回受影响的行的数目，如果最近一次查询失败的话，函数返回 -1。 

如果最近一次操作是没有任何条件（WHERE）的 DELETE 查询，在表中所有的记录都会被删除，但本函数返回值在 4.1.2 版之前都为 0。 

当使用 UPDATE 查询，MySQL 不会将原值和新值一样的列更新。这样使得 mysql_affected_rows() 函数返回值不一定就是查询条件所符合的记录数，只有真正被修改的记录数才会被返回。 

REPLACE 语句首先删除具有相同主键的记录，然后插入一个新记录。本函数返回的是被删除的记录数加上被插入的记录数。
*/

intval();
/*
int intval ( mixed var [, int base] )

通过使用特定的进制转换（默认是十进制），返回变量 var 的 integer 数值。 

var 可以是任何标量类型。intval() 不能用于 array 或 object。 

注: 除非 var 参数是字符串，否则 intval() 的 base 参数不会有效果。
*/

mysql_result();
/*
mixed mysql_result ( resource result, int row [, mixed field] )

mysql_result() 返回 MySQL 结果集中一个单元的内容。字段参数可以是字段的偏移量或者字段名，或者是字段表点字段名（tablename.fieldname）。如果给列起了别名（'select foo as bar from...'），则用别名替代列名。 

当作用于很大的结果集时，应该考虑使用能够取得整行的函数（在下边指出）。这些函数在一次函数调用中返回了多个单元的内容，比 mysql_result() 快得多。此外注意在字段参数中指定数字偏移量比指定字段名或者 tablename.fieldname 要快得多。 

调用 mysql_result() 不能和其它处理结果集的函数混合调用。
*/

htmlspecialchars();
/*
string htmlspecialchars ( string string [, int quote_style [, string charset]] )

Certain characters have special significance in HTML, and should be represented by HTML entities if they are to preserve their meanings. This function returns a string with some of these conversions made; the translations made are those most useful for everyday web programming. If you require all HTML character entities to be translated, use htmlentities() instead. 

This function is useful in preventing user-supplied text from containing HTML markup, such as in a message board or guest book application. The optional second argument, quote_style, tells the function what to do with single and double quote characters. The default mode, ENT_COMPAT, is the backwards compatible mode which only translates the double-quote character and leaves the single-quote untranslated. If ENT_QUOTES is set, both single and double quotes are translated and if ENT_NOQUOTES is set neither single nor double quotes are translated. 

The translations performed are: 

'&' (ampersand) becomes '&amp;' 
'"' (double quote) becomes '&quot;' when ENT_NOQUOTES is not set. 
''' (single quote) becomes '&#039;' only when ENT_QUOTES is set. 
'<' (less than) becomes '&lt;' 
'>' (greater than) becomes '&gt;' 
*/

array_unique();
/*
array array_unique ( array array )

array_unique() 接受 array 作为输入并返回没有重复值的新数组。 

注意键名保留不变。array_unique() 先将值作为字符串排序，然后对每个值只保留第一个遇到的键名，接着忽略所有后面的键名。这并不意味着在未排序的 array 中同一个值的第一个出现的键名会被保留。 

注: 当且仅当 (string) $elem1 === (string) $elem2 时两个单元被认为相同。就是说，当字符串的表达一样时。 第一个单元将被保留。
*/

basename();
/*
string basename ( string path [, string suffix] )


给出一个包含有指向一个文件的全路径的字符串，本函数返回基本的文件名。如果文件名是以 suffix 结束的，那这一部分也会被去掉。 

在 Windows 中，斜线（/）和反斜线（\）都可以用作目录分隔符。在其它环境下是斜线（/）.
*/

strpos();
/*
int strpos ( string haystack, mixed needle [, int offset] )

Returns the numeric position of the first occurrence of needle in the haystack string. Unlike the strrpos(), this function can take a full string as the needle parameter and the entire string will be used. 

If needle is not found, strpos() will return boolean FALSE
*/

extract();
/*
int extract ( array var_array [, int extract_type [, string prefix]] )

本函数用来将变量从数组中导入到当前的符号表中。接受结合数组 var_array 作为参数并将键名当作变量名，值作为变量的值。对每个键／值对都会在当前的符号表中建立变量，并受到 extract_type 和 prefix 参数的影响。 

注: 自版本 4.0.5 起本函数返回被提取的变量数目。 

注: EXTR_IF_EXISTS 和 EXTR_PREFIX_IF_EXISTS 是版本 4.2.0 中引进的。 

注: EXTR_REFS 是版本 4.3.0 中引进的。 

extract() 检查每个键名看是否可以作为一个合法的变量名，同时也检查和符号表中已有的变量名的冲突。对待非法／数字和冲突的键名的方法将根据 extract_type 参数决定。可以是以下值之一： 

EXTR_OVERWRITE
如果有冲突，覆盖已有的变量。 

EXTR_SKIP
如果有冲突，不覆盖已有的变量。 

EXTR_PREFIX_SAME
如果有冲突，在变量名前加上前缀 prefix。 

EXTR_PREFIX_ALL
给所有变量名加上前缀 prefix。自 PHP 4.0.5 起这也包括了对数字索引的处理。 

EXTR_PREFIX_INVALID
仅在非法／数字的变量名前加上前缀 prefix。本标记是 PHP 4.0.5 新加的。 

EXTR_IF_EXISTS
仅在当前符号表中已有同名变量时，覆盖它们的值。其它的都不处理。可以用在已经定义了一组合法的变量，然后要从一个数组例如 $_REQUEST 中提取值覆盖这些变量的场合。本标记是 PHP 4.2.0 新加的。 

EXTR_PREFIX_IF_EXISTS
仅在当前符号表中已有同名变量时，建立附加了前缀的变量名，其它的都不处理。本标记是 PHP 4.2.0 新加的。 

EXTR_REFS
将变量作为引用提取。这有力地表明了导入的变量仍然引用了 var_array 参数的值。可以单独使用这个标志或者在 extract_type 中用 OR 与其它任何标志结合使用。本标记是 PHP 4.3.0 新加的。 

如果没有指定 extract_type，则被假定为 EXTR_OVERWRITE。 

注意 prefix 仅在 extract_type 的值是 EXTR_PREFIX_SAME，EXTR_PREFIX_ALL，EXTR_PREFIX_INVALID 或 EXTR_PREFIX_IF_EXISTS 时需要。如果附加了前缀后的结果不是合法的变量名，将不会导入到符号表中。 

extract() 返回成功导入到符号表中的变量数目.
*/

eval();
/*
mixed eval ( string code_str )

eval() evaluates the string given in code_str as PHP code. Among other things, this can be useful for storing code in a database text field for later execution. 

There are some factors to keep in mind when using eval(). Remember that the string passed must be valid PHP code, including things like terminating statements with a semicolon so the parser doesn't die on the line after the eval(), and properly escaping things in code_str. 

Also remember that variables given values under eval() will retain these values in the main script afterwards. 

A return statement will terminate the evaluation of the string immediately. As of PHP 4, eval() returns NULL unless return is called in the evaluated code, in which case the value passed to return is returned. In case of a parse error in the evaluated code, eval() returns FALSE. In case of a fatal error in the evaluated code, the whole script exits. In PHP 3, eval() does not return a value.
*/

base64_encode();
/*
string base64_encode ( string data )

base64_encode() returns 使用 base64 对 data 进行编码。设计此种编码是为了使二进制数据可以通过非纯 8-bit 的传输层传输，例如电子邮件的主体。 

Base64-encoded 数据要比原始数据多占用 33% 左右的空间。
*/

chunk_split();
/*
chunk_split -- 将字符串分割成小块
描述
string chunk_split ( string body [, int chunklen [, string end]] )

使用此函数将字符串分割成小块非常有用。例如将 base64_encode() 的输出转换成符合 RFC 2045 语义的字符串。它会在每 chunklen（默认为 76）个字符后边插入 end（默认为“\r\n”）。此函数会返回新的字符串，而不会修改原有字符串。
*/

strrpos();
/*
int strrpos ( string haystack, string needle [, int offset] )

Returns the numeric position of the last occurrence of needle in the haystack string. Note that the needle in this case can only be a single character in PHP 4. If a string is passed as the needle, then only the first character of that string will be used. 

If needle is not found, returns FALSE.
*/

strcasecmp();
/*
int strcasecmp ( string str1, string str2 )

Returns < 0 if str1 is less than str2; > 0 if str1 is greater than str2, and 0 if they are equal.
*/

rawurlencode();
/*
string rawurlencode ( string str )

返回字符串，此字符串中除了 -_. 之外的所有非字母数字字符都将被替换成百分号（%）后跟两位十六进制数。这是在 RFC 1738 中描述的编码，是为了保护原义字符以免其被解释为特殊的 URL 定界符，同时保护 URL 格式以免其被传输媒体（像一些邮件系统）使用字符转换时弄乱。
*/

getenv();
/*
string getenv ( string varname )

Returns the value of the environment variable varname, or FALSE on an error. 
*/

ob_start();
/*
bool ob_start ( [callback output_callback [, int chunk_size [, bool erase]]] )

This function will turn output buffering on. While output buffering is active no output is sent from the script (other than headers), instead the output is stored in an internal buffer. 

The contents of this internal buffer may be copied into a string variable using ob_get_contents(). To output what is stored in the internal buffer, use ob_end_flush(). Alternatively, ob_end_clean() will silently discard the buffer contents. 

An optional output_callback function may be specified. This function takes a string as a parameter and should return a string. The function will be called when ob_end_flush() is called, or when the output buffer is flushed to the browser at the end of the request. When output_callback is called, it will receive the contents of the output buffer as its parameter and is expected to return a new output buffer as a result, which will be sent to the browser. If the output_callback is not a callable function, this function will return FALSE. If the callback function has two parameters, the second parameter is filled with a bit-field consisting of PHP_OUTPUT_HANDLER_START, PHP_OUTPUT_HANDLER_CONT and PHP_OUTPUT_HANDLER_END. 

注: In PHP 4.0.4, ob_gzhandler() was introduced to facilitate sending gz-encoded data to web browsers that support compressed web pages. ob_gzhandler() determines what type of content encoding the browser will accept and will return its output accordingly. 

注: Before PHP 4.3.2 this function did not return FALSE in case the passed output_callback can not be executed.
*/

list();
/*
void list ( mixed varname, mixed ... )

像 array() 一样，这不是真正的函数，而是语言结构。list() 用一步操作给一组变量进行赋值。 

注: list() 仅能用于数字索引的数组并假定数字索引从 0 开始。
*/

array_merge();
/*
array array_merge ( array array1 [, array array2 [, array ...]] )

array_merge() 将一个或多个数组的单元合并起来，一个数组中的值附加在前一个数组的后面。返回作为结果的数组。 

如果输入的数组中有相同的字符串键名，则该键名后面的值将覆盖前一个值。然而，如果数组包含数字键名，后面的值将不会覆盖原来的值，而是附加到后面。 

如果只给了一个数组并且该数组是数字索引的，则键名会以连续方式重新索引。
*/

pow();
/*
number pow ( number base, number exp )

返回 base 的 exp 次方的幂。如果可能，本函数会返回 integer。 

如果不能计算幂，将发出一条警告，pow() 将返回 FALSE。PHP 4.2.0 版开始 pow() 不要产生任何的警告。 

注: PHP 不能处理负数的 base。
*/

abs();
/*
number abs ( mixed number )

返回参数 number 的绝对值。如果参数 number 是 float，则返回的类型也是 float，否则返回 integer（因为 float 通常比 integer 有更大的取值范围）。
*/

mt_rand();
/*
int mt_rand ( [int min, int max] )

很多老的 libc 的随机数发生器具有一些不确定和未知的特性而且很慢。PHP 的 rand() 函数默认使用 libc 随机数发生器。mt_rand() 函数是非正式用来替换它的。该函数用了 Mersenne Twister 中已知的特性作为随机数发生器，它可以产生随机数值的平均速度比 libc 提供的 rand() 快四倍。 

如果没有提供可选参数 min 和 max，mt_rand() 返回 0 到 RAND_MAX 之间的伪随机数。例如想要 5 到 15（包括 5 和 15）之间的随机数，用 mt_rand(5, 15)。 
*/

unserialize();
/*
mixed unserialize ( string str [, string callback] )

unserialize() 对单一的已序列化的变量进行操作，将其转换回 PHP 的值。返回的是转换之后的值，可为 integer、float、string、array 或 object。如果传递的字符串不可解序列化，则返回 FALSE。 

unserialize_callback_func 指令: 如果在解序列化的时候需要实例化一个未定义类，则可以设置回调函数以供调用（以免得到的是不完整的 object “__PHP_Incomplete_Class”）。可通过 php.ini、ini_set() 或 .htaccess 定义‘unserialize_callback_func’。每次实例化一个未定义类时它都会被调用。若要禁止这个特性，只需置空此设定。还需要注意的是 unserialize_callback_func 指令是从 PHP 4.2.0 开始提供使用的。 

注: callback 参数是在 PHP 4.2.0 中添加的 

若被解序列化的变量是一个对象，在成功地重新构造对象之后，PHP 会自动地试图去调用 __wakeup() 成员函数（如果存在的话）。 
*/

ini_get();
/*
string ini_get ( string varname )

Returns the value of the configuration option on success. Failure, such as querying for a non-existent value, will return an empty string. 

When querying boolean values: A boolean ini value of off will be returned as an empty string or "0" while a boolean ini value of on will be returned as "1". 

When querying memory size values: Many ini memory size values, such as upload_max_filesize, are stored in the php.ini file in shorthand notation. ini_get() will return the exact string stored in the php.ini file and NOT its integer equivalent. Attempting normal arithmetic functions on these values will not have otherwise expected results. The example below shows one way to convert shorthand notation into bytes, much like how the PHP source does it.
*/
?>