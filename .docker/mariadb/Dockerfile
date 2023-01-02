FROM mariadb:latest

WORKDIR /fixtures

COPY ./fixtures/app.sql .
COPY ./fixtures/company.sql .
COPY ./fixtures/run_fixtures.sh .

RUN chmod +x run_fixtures.sh

CMD ["mysqld"]

EXPOSE 3306
