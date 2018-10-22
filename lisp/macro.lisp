(defmacro backwards (expr) (reverse expr))

(backwards ("hello, world~%" t format))

;;;
(defun make-comparsion-expr (field value)
  (list 'equal (list 'getf 'cd field) value))
(format t "~a~%" (make-comparsion-expr :rating 10))

(defun make-comparsion-expr-v2 (field value)
  `(equal (getf cd ,field) ,value))
(format t "~a~%" (make-comparsion-expr-v2 :rating 10))
