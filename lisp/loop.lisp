(dotimes (x 20)
  (dotimes (y 20)
    (format t "~4d" (* (1+ x) (1+ y))))
  (format t "~%"))

(do ((n 0 (1+ n))
     (cur 0 next)
     (next 1 (+ cur next)))
  ((= 10 n) (format t "curl: ~d~%" cur)))
