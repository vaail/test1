FROM php:7.1.7-cli
COPY . /project
WORKDIR /project
ENV TEST_DATE "2017-09-04"
CMD php bin/console app:get-week-number ${TEST_DATE}