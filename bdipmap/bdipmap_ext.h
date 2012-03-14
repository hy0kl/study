#define BD_SEPARATOR '\t' 
#define BD_MAX_ARRAY_SIZE 2048 
#define BD_CHAR_TO_INT 32 
#define BD_LINE_MAX 128

typedef unsigned long bdip_type;

typedef struct _ip_map_data {
    int count;
    bdip_type array_data[BD_MAX_ARRAY_SIZE][3];
    
} ip_map_data;

int bd_check_str2int(int count)
{
    int res = 0;
    if (count >= BD_CHAR_TO_INT)
    {
        php_error_docref(NULL TSRMLS_CC, E_NOTICE, "Notice: ip data string is too longer, out of %d.", BD_CHAR_TO_INT);
        res = 1;
    }

    return res;
}

int bd_search_region(bdip_type ip_long, ip_map_data *ip_map) 
{
    int region = -1;
    int top = ip_map ? ip_map->count - 1 : -1;

    if (top < 0)
    {
        return region;
    }

    int bottom = 0;
    int found = 0;

    while (top >= bottom && 0 == found)
    {
        int mid = (top + bottom) / 2;

        if (ip_long == ip_map->array_data[mid][0]
             || ip_long == ip_map->array_data[mid][1]
             || (ip_long > ip_map->array_data[mid][0]) && ip_long < ip_map->array_data[mid][1])
        {
            found = 1;
            region = ip_map->array_data[mid][2];
        }
        else if (ip_long < ip_map->array_data[mid][0])
        {
            top = mid - 1;
        }
        else
        {
            bottom = mid + 1;
        }
    }

    return region; 
}

ip_map_data *bd_init_ipmap()
{
    /**const char *path = "/home/hy0kl/study/data/ip.map";*/
    const char *path = INI_STR("bdipmap.data_path");
    char line[BD_LINE_MAX];
    char *p;
    FILE *fp = NULL;
    static ip_map_data *ip_map = NULL;

    /*ip_map = malloc(sizeof(ip_map_data));*/
    ip_map = pemalloc(sizeof(ip_map_data), 1);

    if (NULL == ip_map)
    {
        php_error_docref(NULL TSRMLS_CC, E_WARNING, "Warning: It need more memory.");
        return ip_map;
    }

    fp = fopen(path, "r");
    if (fp)
    {
        int i = 0;
        while (NULL != fgets(line, BD_LINE_MAX, fp))
        {
            size_t str_len = strlen(line);
            if (str_len)
            {
                p = line + str_len - 1;
                *p = '\0';
            }

            char str2int[BD_CHAR_TO_INT] = "\0";
            /* int atoi(const char *nptr);*/
            bdip_type ip_container[3] = {0, 0, 0};
            
            size_t j = 0, k = 0, m = 0;
            for (; j < str_len && m < 3; j++)
            {
                str2int[k] = line[j];
                k++;
                
                if (BD_SEPARATOR == line[j] || '\0' == line[j] || bd_check_str2int(k + 1))
                {
                    str2int[k] = '\0';
                    /*ip_container[m] = atoi(str2int);*/
                    ip_container[m] = atoll(str2int);
                    k = 0;
                    m++; 
                }
            }

            ip_map->array_data[i][0] = ip_container[0];
            ip_map->array_data[i][1] = ip_container[1];
            ip_map->array_data[i][2] = ip_container[2];
            i++;

            if (i >= BD_MAX_ARRAY_SIZE)
            {
                php_error_docref(NULL TSRMLS_CC, E_WARNING, "Warning: The number of ip data out of BD_MAX_ARRAY_SIZE %d.", BD_MAX_ARRAY_SIZE);
                break; 
            }
        }

        ip_map->count = i;
        fclose(fp);
    }
    else
    {
        php_error_docref(NULL TSRMLS_CC, E_WARNING, "Warning: Can NOT open data file %s.", path);
    }

    return ip_map;
}
