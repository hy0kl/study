/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * @see: https://github.com/kbranigan/cJSON
 * gcc cJSON.c test.c -o test -lm
 * */
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdint.h>
#include "cJSON.h"  //需要把该头文件放在后面包含  否则会找不到size_t
//解析JSON
void parse_json(const char *filename)
{
    printf("----------------parse json start-------------------------------\n");
    
    //从文件中读取要解析的JSON数据
    FILE *fp = fopen(filename, "r");
    fseek(fp, 0, SEEK_END);
    long len = ftell(fp);
    fseek(fp, 0, SEEK_SET);
    char *data = (char*)malloc(len + 1);
    fread(data, 1, len, fp);
    fclose(fp);
    printf("%s", data);
    //解析JSON数据
    cJSON *root_json = cJSON_Parse(data);    //将字符串解析成json结构体
    if (NULL == root_json)
    {
        printf("error:%s\n", cJSON_GetErrorPtr());
        cJSON_Delete(root_json);
        return;
    }
    //"name":"EVDI"
    cJSON *name_json = cJSON_GetObjectItem(root_json, "name");
    if (name_json != NULL)
    {
        char *name = cJSON_Print(name_json);    //将JSON结构体打印到字符串中 需要自己释放
        printf("name:%s\n", name);
        free(name);
    }
    //"data":"..."
    //id
    cJSON *data_json = cJSON_GetObjectItem(root_json, "data");
    int id = cJSON_GetObjectItem(data_json, "id")->valueint;
    printf("id:%d\n", id);
    //username
    char *username = cJSON_Print(cJSON_GetObjectItem(data_json, "username"));
    printf("username:%s\n", username);
    free(username);
    //userpass
    char *userpass = cJSON_Print(cJSON_GetObjectItem(data_json, "userpass"));
    printf("userpass:%s\n", userpass);
    free(userpass);
    //version
    char *version = cJSON_Print(cJSON_GetObjectItem(data_json, "version"));
    printf("version:%s\n", version);
    free(version);
    free(data);
 
    printf("----------------parse json end--------------------------------\n");
}
//创建JSON
void create_json()
{
    printf("----------------create json start-----------------------------\n");
    //组JSON
    cJSON *root_json = cJSON_CreateObject();
    cJSON_AddItemToObject(root_json, "name", cJSON_CreateString("EVDI"));
    cJSON *data_json = cJSON_CreateObject();
    cJSON_AddItemToObject(root_json, "data", data_json);
    //添加的另一种方式:cJSON_AddNumberToObject(data_json, "id", 1);通过源码发现仅仅是对cJSON_AddItemToObject的define
    cJSON_AddItemToObject(data_json, "id", cJSON_CreateNumber(1));
    //添加的另一种方式:cJSON_AddStringToObject(data_json, "username", "hahaya");
    cJSON_AddItemToObject(data_json, "username", cJSON_CreateString("hahaya"));
    cJSON_AddItemToObject(data_json, "userpass", cJSON_CreateString("123456"));
    cJSON_AddItemToObject(data_json, "version", cJSON_CreateString("1.0"));
    //打印JSON
    char *out = cJSON_Print(root_json);
    printf("%s\n", out);
    free(out);
    printf("----------------create json end-------------------------------\n");
}

int main(int argc, char *argv[])
{
    parse_json("test.json");
    create_json();
    return 0;
}
