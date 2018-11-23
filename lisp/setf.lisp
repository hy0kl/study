(defun foo (x) (setf x 10))

(let ((y 20))
  (foo y)
  (print y))
