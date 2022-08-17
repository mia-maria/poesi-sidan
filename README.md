# Poesi-sidan

Poesi-sidan är webbplatsen för alla som älskar poesi! På Poesi-sidan kan man ta del av andras dikter och publicera sina egna dikter. <br>

Här hittar ni en presentationsvideo om poesi-sidan: https://youtu.be/JpLPAMvhsE0

Poesi-sidan är en CRUD-applikation. Jag använder mig av PHP8, CodeIgniter4, MySQL8, HTML, CSS, bootstrap och PHPUnit. Med CodeIgniter4 får man en grundbas som jag har byggt vidare på. <br><br>
Jag har sparat uppgifter om databasen i filen .env <br>

# PHP Extensions

Jag har aktiverat följande extensions i min php.ini-fil: <br><br>

extension = curl <br>
extension = intl <br>
extension = mbstring <br>
extension = mysqli <br>
extension = openssl <br><br>
 
zend_extension = php_xdebug-3.0.4-8.0-vs16-nts-x86_64dll <br>
xdebug.mode = coverage <br>

# MySQL Tables

Här kan ni se hur jag skapade mina tabeller. <br><br>

CREATE TABLE users ( <br>
  -> id INT AUTO_INCREMENT PRIMARY KEY, <br>
  -> name VARCHAR(100), <br>
  -> password VARCHAR(255) NOT NULL, <br> 
  -> CONSTRAINT users_unique UNIQUE (name) <br>
) <br><br>

ALTER TABLE users ADD email VARCHAR(100) UNIQUE AFTER name <br><br>

CREATE TABLE poems ( <br>
  -> id INT AUTO_INCREMENT PRIMARY KEY, <br>
  -> title VARCHAR(200), <br>
  -> author_id INT, <br> 
  -> body TEXT NOT NULL <br>
) <br><br>

# Testramverk PHPUnit

Ladda ner testramverket: composer require --dev phpunit/phpunit <br>

För att kunna köra automatiska test behövs information om test-databasen, även om jag inte använder den. Jag har fyllt i nedanstående uppgifter i .env-filen. <br>

database.tests.hostname = <br>
database.tests.database = <br>
database.tests.username = <br>
database.tests.password = <br>
database.tests.DBDriver = <br>

För att köra de automatiska testen: <br>
Gå till mappen CodeIgniter <br>
Kör kommando: vendor/bin/phpunit <br>

(5 test följde med när jag laddade ner testramverket.)

# Köra applikationen

Gå till mappen CodeIgniter <br>
Kör kommando: php spark serve