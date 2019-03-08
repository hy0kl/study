(define (sum-two a b c)
  (cond ((and (<= a b) (<= a c)) (+ b c))
        ((and (<= b a) (<= b c)) (+ a c))
        ((and (<= c a) (<= c b)) (+ a b))
        (else 0)))

(define (abs x)
  (cond ((> x 0) x)
        ((= x 0) 0)
        ((< x 0) (- x))))

; 求绝对值第二个版本
(define (abs-v2 x)
  (cond ((< x 0) (- x))
        (else x)))

; 求绝对值v3
(define (abs-v3 x)
  (if (< x 0)
    (- x)
    x))

(define (big-one a b)
  (cond ((> a  b) a)
        (else b)))
