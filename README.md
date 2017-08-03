How to test
=====

Run following commands:
```sh
composer install
docker build -t test1 .
docker run --rm  -e "TEST_DATE=2017-09-04" test1
```