#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include <curl/curl.h>

#define CACHE_NUM       2 
#define CURL_BUF_LEN    500 * 1024
#define DEFAULT_LINK_LENGTH 1024

#define BASE_URL "http://www.baidu.com/s?wd=df&pn=%d&tn=baiduhome_pg"

typedef struct  _curl_chunk{
    int    index;
    char  *curl_body;
    size_t size;
} curl_chunk;

/****/
curl_chunk  g_curl_chunk[CACHE_NUM];

static size_t
curl_write_chunk_callback(void *contents, size_t size, size_t nmemb, void *userp)
{
    size_t realsize = size * nmemb;
    int index = -1;
    curl_chunk *mem = (curl_chunk *)userp;

    index = mem->index;
    if (index < 0 || mem->size + realsize > CURL_BUF_LEN)
    {
        return 0;
    }

    printf("index: %d\n", index);
    printf("realsize: %d, size: %d, nmemb: %d\n", (int)realsize, (int)size, (int)nmemb);
    printf("***\n\tcontents:[%s]\n$$$\n", (char *)contents);

    memcpy(&(mem->curl_body[mem->size]), contents, realsize);
    mem->curl_body[CURL_BUF_LEN - 1] = '\0';
    mem->size += realsize;

    return realsize;
}


int curl_get_contents(const int index, const char *url, long time_out)
{
    int ret = 0;
    CURL *curl_handle;

    curl_chunk *chunk = &(g_curl_chunk[index]);

    curl_global_init(CURL_GLOBAL_ALL);

    /* init the curl session */
    curl_handle = curl_easy_init();

    /* specify URL to get */
    curl_easy_setopt(curl_handle, CURLOPT_URL, url);

    /* send all data to this function  */
    curl_easy_setopt(curl_handle, CURLOPT_WRITEFUNCTION, curl_write_chunk_callback);

    /* we pass our 'chunk' struct to the callback function */
    curl_easy_setopt(curl_handle, CURLOPT_WRITEDATA, (void *)chunk);

    /* some servers don't like requests that are made without a user-agent
     field, so we provide one */
    curl_easy_setopt(curl_handle, CURLOPT_USERAGENT,
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.142 Safari/535.19");
    
    /* set timeout */
    curl_easy_setopt(curl_handle, CURLOPT_TIMEOUT_MS, time_out);

    /* get it! */
    curl_easy_perform(curl_handle);

    /* cleanup curl stuff */
    curl_easy_cleanup(curl_handle);

    /* we're done with libcurl, so clean it up */
    curl_global_cleanup();

    return 0;
}


int main(int argc, char *argv[])
{
    int i;
    int page = 0;
    int time_out = 100;
    char url[DEFAULT_LINK_LENGTH] = {0};

    for (i = 0; i < CACHE_NUM; i++)
    {
        g_curl_chunk[i].index = i;
        g_curl_chunk[i].size  = 0;
        
        g_curl_chunk[i].curl_body = (char *)malloc(CURL_BUF_LEN);
        if (NULL == g_curl_chunk[i].curl_body)
        {
            fprintf(stderr, "Can NOT malloc memory for curl buffer:%d.\n", CURL_BUF_LEN);
            exit(-1);
        }

        memset(g_curl_chunk[i].curl_body, 0, CURL_BUF_LEN);

        page = i * 10;
        snprintf(url, DEFAULT_LINK_LENGTH, BASE_URL, page);
        printf("url: %s\n", url);

        curl_get_contents(i, url, time_out); 

        printf("<<<index %d ->curl_body:%s\n", i, g_curl_chunk[i].curl_body);
        printf("    size:%d>>>\n\n", g_curl_chunk[i].size);
    }

    return 0;
}
