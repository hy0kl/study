; 斐波那契数列

; 树形递归
(define (fib-v1 n)
  (cond ((= n 0) 0)
        ((= n 1) 1)
        (else (+ (fib-v1 (- n 1))
                 (fib-v1 (- n 2))))))

; 迭代法
(define (fib-v2 n)
  (fib-v2-iter 1 0 n))

(define (fib-v2-iter a b count)
  (if (= count 0)
    b
    (fib-v2-iter (+ a b) a (- count 1))))

