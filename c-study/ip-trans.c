/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */

#include <stdio.h>
#include <stdlib.h>

int main(int argc, char *argv[]) {
    uint32_t ip1 = 172;
    uint32_t ip2 = 1;
    uint32_t ip3 = 11;
    uint32_t ip4 = 13;

    uint32_t ip32 = ip1 << 24 | ip2 << 16 | ip3 << 8 | ip4;
    printf("ip32 = %u \n", ip32);
    printf("sizeof(uint32_t) = %lu\n", sizeof(uint32_t));
    
    return 0;
}

/* vim:set ft=c ts=4 sw=4 et fdm=marker: */

