; create cd
(defun make-cd (title artist rating ripped)
  (list :title title :artist artist :rating rating :ripped ripped))

; db
(defvar *db* nil)

(defun add-record (cd)
  (push cd *db*))

; dump-db
(defun dump-db ()
  (dolist (cd *db*)
    (format t "~{~a: ~10t~a~%~}~%" cd)))

(defun dump-db-v2 ()
  (format t "~{~{~a: ~10t~a~%~}~%~}" *db*))

(add-record (make-cd "Roses" "Kathy" 7 t))
(add-record (make-cd "Fly" "Dixie" 8 t))
(add-record (make-cd "Home" "Dixie Chicks" 9 t))

;(print *db*)
(format t "use v1~%")
(dump-db)
(format t "use v2~%")
(dump-db-v2)

(defun prompt-read (prompt)
  (format *query-io* "~a: " prompt)
  (force-output *query-io*)
  (read-line *query-io*))

(defun prompt-for-cd ()
  (make-cd 
    (prompt-read "Title")
    (prompt-read "Artist")
    (or (parse-integer (prompt-read "Rating") :junk-allowed t) 0)
    (y-or-n-p "Ripped [y/n]: ")))

(defun add-cds ()
  (loop (add-record (prompt-for-cd))
        (if (not (y-or-n-p "Another? [y/n]: ")) (return))))

(add-cds)
(dump-db)
