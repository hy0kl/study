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

;;;

(defun save-db (filename)
  (with-open-file (out filename
                       :direction :output
                       :if-exists :supersede)
    (with-standard-io-syntax
      (print *db* out))))

(save-db "./cds.db")

; 加载已有库
(defun load-db (filename)
  (with-open-file (in filename)
    (with-standard-io-syntax
      (setf *db* (read in)))))

; query
;; select-by-* 一堆重复代码...
(defun select-by-artist (artist)
  (remove-if-not
    #'(lambda (cd) (equal (getf cd :artist) artist))
    *db*))

;; 同样存在类似代码的情况
(defun select (selector-fn)
  (remove-if-not selector-fn *db*))

(defun artist-selector (artist)
  #'(lambda (cd) (equal (getf cd :artist) artist)))

(format t "query result: ~a~%" (select (artist-selector "Dixie Chicks")))

;; 进阶函数
(defun where (&key title artist rating (ripped nil ripped-p))
  #'(lambda (cd)
      (and
        (if title    (equal (getf cd :title) title) t)
        (if artist   (equal (getf cd :artist) artist) t)
        (if rating   (equal (getf cd :rating) rating) t)
        (if ripped-p (equal (getf cd :ripped-p) ripped) t))))

(format t "where query, use: Dixie Chicks, result: ~a~%" (select (where :artist "Dixie Chicks")))

; update
(defun update (selector-fn &key title artist rating (ripped nil ripped-p))
  (setf *db*
        (mapcar
          #'(lambda (row)
              (when (funcall selector-fn row)
                (if title    (setf (getf row :title) title))
                (if artist   (setf (getf row :artist) artist))
                (if rating   (setf (getf row :rating) rating))
                (if ripped-p (setf (getf row :ripped) ripped)))
              row) *db* )))

(update (where :artist "Dixie Chicks") :rating 11)
(dump-db)
