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

#ifndef PHP_BDIPMAP_H
#define PHP_BDIPMAP_H

extern zend_module_entry bdipmap_module_entry;
#define phpext_bdipmap_ptr &bdipmap_module_entry

#ifdef PHP_WIN32
#	define PHP_BDIPMAP_API __declspec(dllexport)
#elif defined(__GNUC__) && __GNUC__ >= 4
#	define PHP_BDIPMAP_API __attribute__ ((visibility("default")))
#else
#	define PHP_BDIPMAP_API
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

/** include ext header file.*/
#include "bdipmap_ext.h"

PHP_MINIT_FUNCTION(bdipmap);
PHP_MSHUTDOWN_FUNCTION(bdipmap);
PHP_RINIT_FUNCTION(bdipmap);
PHP_RSHUTDOWN_FUNCTION(bdipmap);
PHP_MINFO_FUNCTION(bdipmap);

/** PHP_FUNCTION(confirm_bdipmap_compiled);*/	/* For testing, remove later. */
PHP_FUNCTION(bdipmap_search_region);	/* baidu ip map, to search region by ip. */
PHP_FUNCTION(bdipmap_debug);	/* baidu ip map, to search region by ip. */

/* 
  	Declare any global variables you may need between the BEGIN
	and END macros here:     
*/
ZEND_BEGIN_MODULE_GLOBALS(bdipmap)
	ip_map_data *bd_ip_map;
ZEND_END_MODULE_GLOBALS(bdipmap)
/***/

/* In every utility function you add that needs to use variables 
   in php_bdipmap_globals, call TSRMLS_FETCH(); after declaring other 
   variables used by that function, or better yet, pass in TSRMLS_CC
   after the last function argument and declare your utility function
   with TSRMLS_DC after the last declared argument.  Always refer to
   the globals in your function as BDIPMAP_G(variable).  You are 
   encouraged to rename these macros something shorter, see
   examples in any other php module directory.
*/

#ifdef ZTS
#define BDIPMAP_G(v) TSRMG(bdipmap_globals_id, zend_bdipmap_globals *, v)
#else
#define BDIPMAP_G(v) (bdipmap_globals.v)
#endif

#endif	/* PHP_BDIPMAP_H */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
