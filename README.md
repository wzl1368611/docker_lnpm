## docker_lpnm
最小的 nginx-php-mysql 系统

使用docker-compose 构建一个nginx-php-mysql系统，可以通过浏览器访问以下页面：

* localhost/index
* localhost/text.php
* localhost/mysql.php
  

### 目录结构

    docker_lpnm
      conf
        nginx.conf
      html
        index.html
        mysql.php
        test.php
      docker-compose.yml

---
### nginx.conf中
    
    worker_processes  1;
    events {
        worker_connections  1024;
    }
    http {                                                  
        include       mime.types;
        default_type  application/octet-stream;
        sendfile        on;
        keepalive_timeout  65;
        server {
            listen       80;
            server_name  localhost;
            location / {
                root   /usr/share/nginx/html;
                index  index.html index.htm;
            }

            error_page   500 502 503 504  /50x.html;
            location = /50x.html {
                root   /usr/share/nginx/html;
            }

            location ~ \.php$ {                     
                fastcgi_pass    php:9000;
                fastcgi_index   index.php;
                fastcgi_param   SCRIPT_FILENAME     /var/www/html/$fastcgi_script_name;    
                include         fastcgi_params;
            }
        }
    }
 

### index.html中

    index.html
    
### mysql.php中
    <?php
    $servername = 'mysql';
    $username = 'root';
    $password = '123456';
    $conn = mysqli_connect($servername,$username,$password);
    if(! $conn)
    {
        die('could not connect:'.mysqli_error());
    }
        echo 'mysql connected!!!';
        mysqli_close($conn)
    ?>
    
### test.php中

    <?php
    phpinfo();
    ?>
    docker-compose.yml
    version: "3"
    services:
      nginx:
        image: nginx:alpine
        ports:
        - 80:80
        volumes:
        - ./html:/usr/share/nginx/html
        - ./conf/nginx.conf:/etc/nginx/nginx.conf
      php:
        image: devilbox/php-fpm:8.0-work-0.106
        volumes:
        - ./html:/var/www/html
      mysql:
        image: mysql:5.6
        environment:
        - MYSQL_ROOT_PASSWORD=123456
### docker-compose.yml

  version: "3"
  services:
    nginx:
      image: nginx:alpine
      ports:
      - 80:80
      volumes:
      - ./html:/usr/share/nginx/html
      - ./conf/nginx.conf:/etc/nginx/nginx.conf
    php:
      image: devilbox/php-fpm:8.0-work-0.106
      volumes:
      - ./html:/var/www/html
    mysql:
      image: mysql:5.6
      environment:
      - MYSQL_ROOT_PASSWORD=123456
