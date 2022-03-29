# Elasticsearch

將此下載後解壓縮到放置安裝包的位置,如/package/elk

要安裝此包的專案 composer.json 設定

可用絕對或相對路徑,相對路徑以設定的 composer.json 檔案位置為主

下面為絕對路徑示範
```
    "repositories": [
        {
            "type": "path",
            "url": "/package/*"
        }
    ]
```
在專案下指令 composer require phptycoon/elasticsearch

成功的話則可在 composer.json 的 require 看到 phptycoon/elasticsearch