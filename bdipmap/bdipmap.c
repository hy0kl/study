/*
  +----------------------------------------------------------------------+
  | PHP Version 5                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2010 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author:                                                              |
  +----------------------------------------------------------------------+
*/

/* $Id: header 297205 2010-03-30 21:09:07Z johannes $ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_bdipmap.h"

/* If you declare any globals in php_bdipmap.h uncomment this:
*/
ZEND_DECLARE_MODULE_GLOBALS(bdipmap)
/**
*/

/* True global resources - no need for thread safety here */
static int le_bdipmap;

/* {{{ bdipmap_functions[]
 *
 * Every user visible function must have an entry in bdipmap_functions[].
 */
const zend_function_entry bdipmap_functions[] = {
	PHP_FE(bdipmap_search_region,	NULL)
	PHP_FE(bdipmap_debug,	NULL)
	{NULL, NULL, NULL}	/* Must be the last line in bdipmap_functions[] */
};
/* }}} */

/* {{{ bdipmap_module_entry
 */
zend_module_entry bdipmap_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
	STANDARD_MODULE_HEADER,
#endif
	"bdipmap",
	bdipmap_functions,
	PHP_MINIT(bdipmap),
	PHP_MSHUTDOWN(bdipmap),
	PHP_RINIT(bdipmap),		/* Replace with NULL if there's nothing to do at request start */
	PHP_RSHUTDOWN(bdipmap),	/* Replace with NULL if there's nothing to do at request end */
	PHP_MINFO(bdipmap),
#if ZEND_MODULE_API_NO >= 20010901
	"0.1", /* Replace with version number for your extension */
#endif
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_BDIPMAP
ZEND_GET_MODULE(bdipmap)
#endif

/* {{{ PHP_INI
 */
/* Remove comments and fill if you need to have entries in php.ini
PHP_INI_BEGIN()
    STD_PHP_INI_ENTRY("bdipmap.global_value",      "42", PHP_INI_ALL, OnUpdateLong, global_value, zend_bdipmap_globals, bdipmap_globals)
    STD_PHP_INI_ENTRY("bdipmap.global_string", "foobar", PHP_INI_ALL, OnUpdateString, global_string, zend_bdipmap_globals, bdipmap_globals)
PHP_INI_END()
*/
/* }}} */
PHP_INI_BEGIN()
/**STD_PHP_INI_ENTRY("bdipmap.data_path", "./data/ip.map", PHP_INI_ALL, OnUpdateString, data_path, zend_bdipmap_globals, bdipmap_globals)*/
/**PHP_INI_ENTRY("bdipmap.data_path", "./data/ip.map", PHP_INI_ALL, NULL)*/
/** just for php.ini to change it value*/
PHP_INI_ENTRY("bdipmap.data_path", "./data/ip.map", PHP_INI_SYSTEM, NULL)
PHP_INI_END()

/* {{{ php_bdipmap_init_globals
 */
/* Uncomment this function if you have INI entries
*/
static void php_bdipmap_init_globals(zend_bdipmap_globals *bdipmap_globals)
{
	/**
	bdipmap_globals->global_value = 0;
	bdipmap_globals->global_string = NULL;
	*/
}
/**
*/
/* }}} */

/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(bdipmap)
{
	/* If you have INI entries, uncomment these lines 
	REGISTER_INI_ENTRIES();
	*/
	/** add by hy0kl*/
	ZEND_INIT_MODULE_GLOBALS(bdipmap, php_bdipmap_init_globals, NULL);
	REGISTER_INI_ENTRIES();
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(bdipmap)
{
	/* uncomment this line if you have INI entries
	UNREGISTER_INI_ENTRIES();
	*/
	UNREGISTER_INI_ENTRIES();
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request start */
/* {{{ PHP_RINIT_FUNCTION
 */
PHP_RINIT_FUNCTION(bdipmap)
{
	BDIPMAP_G(bd_ip_map) = bd_init_ipmap(); 
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request end */
/* {{{ PHP_RSHUTDOWN_FUNCTION
 */
PHP_RSHUTDOWN_FUNCTION(bdipmap)
{
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION(bdipmap)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "bdipmap support", "enabled");
	php_info_print_table_end();

	/* Remove comments if you have entries in php.ini
	DISPLAY_INI_ENTRIES();
	*/
}
/* }}} */


/* Remove the following function when you have succesfully modified config.m4
   so that your module can be compiled into PHP, it exists only for testing
   purposes. */

/* Every user-visible function in PHP should document itself in the source */
/* {{{ proto string confirm_bdipmap_compiled(string arg)
   Return a string to confirm that the module is compiled in */
PHP_FUNCTION(bdipmap_debug)
{
	char *arg = NULL;
	int arg_len, len;
	char *strg;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &arg, &arg_len) == FAILURE) {
		return;
	}

	len = spprintf(&strg, 0, "Congratulations! You have successfully modified ext/%.78s/config.m4. Module %.78s is now compiled into PHP. bdipmap->data_path = %.78s", "bdipmap", arg, INI_STR("bdipmap.data_path"));
	RETURN_STRINGL(strg, len, 0);
}

/** add search region function for php*/
PHP_FUNCTION(bdipmap_search_region)
{
	bdip_type arg = 0;
	int arg_len;
	int region = -1;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "l", &arg, &arg_len) == FAILURE) {
		/*return;*/
		RETURN_NULL();
	}

	ip_map_data *ip_map = BDIPMAP_G(bd_ip_map);	

	region = bd_search_region(arg, ip_map);

	RETURN_LONG(region);	
}
/* }}} */
/* The previous line is meant for vim and emacs, so it can correctly fold and 
   unfold functions in source code. See the corresponding marks just before 
   function definition, where the functions purpose is also documented. Please 
   follow this convention for the convenience of others editing your code.
*/


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
