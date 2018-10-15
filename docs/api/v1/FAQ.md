# FAQ

+ [分类列表](#分类列表)
+ [分类详情](#分类详情)
+ [文章列表](#文章列表)
+ [文章详情](#文章详情)
+ [最近文章](#最近文章)

### 分类列表

接口(GET)：

```angular2html
/api/v1/faq/categories
```

请求参数：

| 参数 | 默认值 | 说明 |
| --- | --- | --- |
| `page_size` | 10 | 每页显示条数 |
| `page` | 1 | 页码 |

返回参数：

```angular2html
{
    "data": [
        {
            "id": 1,
            "name": "分类一",
            "sort": 1
        },
        {
            "id": 2,
            "name": "分类二",
            "sort": 2
        },
        {
            "id": 3,
            "name": "分类三",
            "sort": 3
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/v1/faq/categories?page=1",
        "last": "http://127.0.0.1:8000/api/v1/faq/categories?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://127.0.0.1:8000/api/v1/faq/categories",
        "per_page": 10,
        "to": 3,
        "total": 3
    }
}
```

> 返回参数不解释了，你懂得。

###  分类详情

接口(GET)：

```angular2html
/api/v1/faq/category/{id}
```

请求参数：

```angular2html
无
```

返回参数：

```angular2html
{
    "data": {
        "id": 1,
        "name": "分类一",
        "sort": 1
    }
}
```

### 文章列表

接口(GET)：

```angular2html
/api/v1/faq/category/{category_id}/articles
```

请求参数：

| 参数 | 默认值 | 说明 |
| --- | --- | --- |
| `page_size` | 10 | 每页显示条数 |
| `page` | 1 | 页码 |

返回参数：

```angular2html
{
    "data": [
        {
            "id": 1,
            "title": "我是文章一",
            "created_at": 1539569104,
            "administrator": {
                "name": "超级管理员"
            }
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/v1/faq/category/1/articles?page=1",
        "last": "http://127.0.0.1:8000/api/v1/faq/category/1/articles?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://127.0.0.1:8000/api/v1/faq/category/1/articles",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```

### 文章详情

接口(GET)：

```angular2html
/api/v1/faq/article/{article_id}
```

请求参数：

```angular2html
无
```

返回参数：

```angular2html
{
    "data": {
        "id": 1,
        "title": "我是文章一",
        "created_at": 1539569104,
        "content": "<h6>我是文章一</h6>",
        "administrator": {
            "name": "超级管理员"
        }
    }
}
```


### 最近文章

接口(GET)：

```angular2html
/api/v1/faq/article/latest
```

请求参数：

| 参数 | 默认值 | 说明 |
| --- | --- | --- |
| `page_size` | 10 | 每页显示条数 |
| `page` | 1 | 页码 |

返回参数：

```angular2html
{
    "data": [
        {
            "id": 1,
            "title": "我是文章一",
            "created_at": 1539569104,
            "administrator": {
                "name": "超级管理员"
            },
            "category": {
                "id": 1,
                "name": "分类一",
                "sort": 1
            }
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/v1/faq/article/latest?page=1",
        "last": "http://127.0.0.1:8000/api/v1/faq/article/latest?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://127.0.0.1:8000/api/v1/faq/article/latest",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```

