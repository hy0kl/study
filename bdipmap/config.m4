dnl $Id$
dnl config.m4 for extension bdipmap

dnl Comments in this file start with the string 'dnl'.
dnl Remove where necessary. This file will not work
dnl without editing.

dnl If your extension references something external, use with:

dnl PHP_ARG_WITH(bdipmap, for bdipmap support,
dnl Make sure that the comment is aligned:
dnl [  --with-bdipmap             Include bdipmap support])

dnl Otherwise use enable:

dnl # Add by hy0kle@gmail.com
PHP_ARG_ENABLE(bdipmap, whether to enable bdipmap support,
dnl Make sure that the comment is aligned:
dnl # delete comment by hy0kl
[  --enable-bdipmap           Enable bdipmap support])

if test "$PHP_BDIPMAP" != "no"; then
  dnl Write more examples of tests here...

  dnl # --with-bdipmap -> check with-path
  dnl SEARCH_PATH="/usr/local /usr"     # you might want to change this
  dnl SEARCH_FOR="/include/bdipmap.h"  # you most likely want to change this
  dnl if test -r $PHP_BDIPMAP/$SEARCH_FOR; then # path given as parameter
  dnl   BDIPMAP_DIR=$PHP_BDIPMAP
  dnl else # search default path list
  dnl   AC_MSG_CHECKING([for bdipmap files in default path])
  dnl   for i in $SEARCH_PATH ; do
  dnl     if test -r $i/$SEARCH_FOR; then
  dnl       BDIPMAP_DIR=$i
  dnl       AC_MSG_RESULT(found in $i)
  dnl     fi
  dnl   done
  dnl fi
  dnl
  dnl if test -z "$BDIPMAP_DIR"; then
  dnl   AC_MSG_RESULT([not found])
  dnl   AC_MSG_ERROR([Please reinstall the bdipmap distribution])
  dnl fi

  dnl # --with-bdipmap -> add include path
  dnl PHP_ADD_INCLUDE($BDIPMAP_DIR/include)

  dnl # --with-bdipmap -> check for lib and symbol presence
  dnl LIBNAME=bdipmap # you may want to change this
  dnl LIBSYMBOL=bdipmap # you most likely want to change this 

  dnl PHP_CHECK_LIBRARY($LIBNAME,$LIBSYMBOL,
  dnl [
  dnl   PHP_ADD_LIBRARY_WITH_PATH($LIBNAME, $BDIPMAP_DIR/lib, BDIPMAP_SHARED_LIBADD)
  dnl # Add by hy0kl
  AC_DEFINE(HAVE_BDIPMAPLIB,1,[ ])
  dnl ],[
  dnl   AC_MSG_ERROR([wrong bdipmap lib version or lib not found])
  dnl ],[
  dnl   -L$BDIPMAP_DIR/lib -lm
  dnl ])
  dnl
  dnl PHP_SUBST(BDIPMAP_SHARED_LIBADD)

  PHP_NEW_EXTENSION(bdipmap, bdipmap.c, $ext_shared)
fi
