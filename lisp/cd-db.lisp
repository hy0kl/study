; create cd
(defun make-cd (title artist rating ripped)
  (list :title title :artist artist :rating rating :ripped ripped))

; db
(defvar *db* nil)

(defun add-record (cd)
  (push cd *db*))

(add-record (make-cd "Roses" "Kathy" 7 t))
(add-record (make-cd "Fly" "Dixie" 8 t))
(add-record (make-cd "Home" "Dixie Chicks" 9 t))

(print *db*)
