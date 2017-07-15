# php-rest-api

Instructions:
 - Launch Server: `docker-compose up`
 - Init Database: `docker exec -i mysql mysql -uroot -ppassroot < database.sql`
 
 EndPoint: `http://0.0.0.0:8080`
 
 Sample Request:
  - `curl -X GET   http://0.0.0.0:8080/user/1`

  - `curl -X GET   http://0.0.0.0:8080/user/`

  - `curl -X GET   http://0.0.0.0:8080/song/1`

  - `curl -X GET   http://0.0.0.0:8080/song/`

  - `curl -X POST \
       http://0.0.0.0:8080/user/ \
       -H 'content-type: application/x-www-form-urlencoded' \
       -d 'name=user%20name%202&email=test%40test.com'`

  - `curl -X POST \
       http://0.0.0.0:8080/song/ \
       -H 'content-type: application/json' \
       -d '{"name": "my pretty song", "time": "300"}'`

  - `curl -X POST \
       http://0.0.0.0:8080/song/ \
       -H 'content-type: application/x-www-form-urlencoded' \
       -d 'name=song%20name%203&time=300'`

  - `curl -X GET    http://0.0.0.0:8080/favorites/1`

  - `curl -X DELETE \
       http://0.0.0.0:8080/favorites/1 \
       -H 'content-type: application/x-www-form-urlencoded' \
       -d songId=2`

  - `curl -X POST \
       http://0.0.0.0:8080/favorites/ \
       -H 'content-type: application/x-www-form-urlencoded' \
       -d 'userId=1&songId=2'`