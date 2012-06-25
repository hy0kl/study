#include <stdio.h>
#include <stdlib.h>

#define BUF_LEN     1024 * 10

typedef struct _list_t list_t;
struct _list_t
{
    char     data[BUF_LEN];
    list_t  *next;
};

list_t *init_list(unsigned int item_count)
{
    list_t *head = NULL;
    list_t *item = NULL;
    list_t *pre_item = NULL;
    unsigned int i = 0;

    if (item_count <= 0)
    {
        fprintf(stderr, "No item count.\n");
        exit(-1);
    }

    for (i = 0; i < item_count; i++)
    {
        item = (list_t *)malloc(sizeof(list_t)); 
        if (NULL == item)
        {
            fprintf(stderr, "Can NOT malloc() for item: %u.\n", i);
            exit(1);
        }

        snprintf(item->data, BUF_LEN, "The current item->data is: %u.", i);
        item->next = NULL;

        if (NULL == head)
        {
            head = item;
        }
        else
        {
            pre_item->next = item;
        }

        pre_item = item;
    }

    return head;
}

void print_list(list_t *list)
{
    if (NULL == list)
    {
        fprintf(stderr, "The list is NULL, please check it out.\n");
        return;
    }

    while (list)
    {
        printf("%s\n", list->data);
        list = list->next;
    }

    return (void)0;
}

int main(int argc, char *argv[])
{
    unsigned int item_count = 10;
    list_t *list = NULL;

    list = init_list(item_count);
    print_list(list);

    //revert_list(list);
    //

    return 0;
}

