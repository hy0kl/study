#include <ctype.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define TMP_STR_BUF_LEN     2 * 1024
#define SHORT_BUF           1024
#define LIFE_STEP_NUM       5

#define DESCRIPTION_0       "在一个奇妙而且美妙的时刻,我在不知道中即将诞生了,\
精彩马上开始..."
#define DESCRIPTION_1       "HI, 大家好,我是一个小蝌蚪"
#define DESCRIPTION_2       "我还是一个小蝌蚪,但经过一段时间的进化,我长出了兩条腿"
#define DESCRIPTION_3       "我依然可以算是一个小蝌蚪,但经过一段时间的进化,\
我有了四条腿,但尾巴却没有退去,我好想去陆地上看看呀"
#define DESCRIPTION_4       "感谢郭嘉,我终于进化成为一只青蛙,可以享受兩栖的快乐了!"

#define NO_LIFE             "None"
#define ORIGINAL_LIFE       "tabpole"
#define EVOLUTION_LIFE      "frog"

typedef struct _life_common_t
{
    int head;
    int eyes;
    int mouth;
} life_common_t;

typedef struct _life_evolution_t
{
    char  life_stat[SHORT_BUF];
    char *description;
    int   breath;
    int   legs;
    int   tail;
} life_evolution_t;

static char life_des[LIFE_STEP_NUM][TMP_STR_BUF_LEN] = {
    DESCRIPTION_0,
    DESCRIPTION_1,
    DESCRIPTION_2,
    DESCRIPTION_3,
    DESCRIPTION_4,
};
static life_common_t life_common;

int print_life(life_evolution_t *life)
{
    if (NULL == life)
    {
        fprintf(stderr, "It is empty point: life\n");
        goto FINISH;
    }

    fprintf(stderr, "生命姿态: %s\n", life->life_stat);
    fprintf(stderr, "生命自述: %s\n", life->description);
    fprintf(stderr, "我有 %d 个头\n", life_common.head);
    fprintf(stderr, "有 %d 个眼睛\n", life_common.eyes);
    fprintf(stderr, "有 %d 个嘴\n",   life_common.mouth);
    fprintf(stderr, "有 %d 条腿\n",   life->legs);
    fprintf(stderr, "有 %d 条尾巴\n", life->tail);
    fprintf(stderr, "我用 %s 呼吸\n", life->breath ? "肺" : "腮");
    fprintf(stderr, "进化\n...\n");

FINISH:
    return 0;
}

int main(int argc, char *argv[])
{
    int i = 0;
    int step = 0;

    life_evolution_t life_evolution[LIFE_STEP_NUM];
    memset(life_evolution, 0, sizeof(life_evolution_t) * LIFE_STEP_NUM);

    life_common.head = 1;
    life_common.eyes = 2;
    life_common.mouth= 1;

    for (i = 0; i < LIFE_STEP_NUM; i++)
    {
        snprintf(life_evolution[i].life_stat, SHORT_BUF, "%s", ORIGINAL_LIFE);
        life_evolution[i].description = life_des[i];
        switch (i)
        {
            case 0:
                snprintf(life_evolution[i].life_stat, SHORT_BUF, "%s", NO_LIFE);
                break;

            case 1:
                life_evolution[i].tail = 1;
                break;

            case 2:
                life_evolution[i].tail = 1;
                life_evolution[i].legs = 2;
                break;

            case 3:
                life_evolution[i].tail = 1;
                life_evolution[i].legs = 4;
                break;

            case 4:
                snprintf(life_evolution[i].life_stat, SHORT_BUF, "%s", EVOLUTION_LIFE);

                life_evolution[i].tail = 0;
                life_evolution[i].legs = 4;
                life_evolution[i].breath = 1;
                break;

            default:
                fprintf(stderr, "Get wrong life step\n");
        }
    }

    if (argc > 1 && 0 != argv[1][0])
    {
        step = atoi(argv[1]);
    }

    if (step > -1 && step < LIFE_STEP_NUM)
    {
        print_life(&(life_evolution[step]));
    }
    else
    {
        fprintf(stderr, "Get wrong life step:[%d]\n", step);   
        fprintf(stderr, "It should be 0~%d\n", LIFE_STEP_NUM);   
    }

    return 0;
}
