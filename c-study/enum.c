#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <string.h>
#include <ctype.h>
#include <unistd.h>

#define logprintf(format, arg...) fprintf(stderr, "[NOTIC] [%s] "format"\n", __func__, ##arg)

enum weekday_t
{
    sun, mou, tue, wed, thu, fri, sat,
};

static char weekday_str[7][16] = {
    "Sun",
    "Mou",
    "Tue",
    "Wed",
    "Thu",
    "Fri",
    "Sat",
};

static void print_day(enum weekday_t weekday)
{
    logprintf("The day is %s.", weekday_str[weekday]);

    return;
}

int
main(int argc, char *argv[])
{
    enum weekday_t  weekday;

    weekday = fri;
    printf("weekday->fri = %d\n", weekday);
    print_day(weekday);

    return 0;
}
