WEATHER
=========

### Requirements

* Docker 
* Docker-compose

### How to run

There is a script to build the docker image and install the dependencies inside it. 
Basically you need to download the repository, enter the folder and run `./run.sh` (if docker is not on root group, run it with sudo). The api would be running on 0.0.0.0:8000

### How easy is to add a new Partner 

Implement the `App\Service\Partner\PartnerInterface` and inject it inside the service `@App\Service\PredictionsFinder`. Just that ;) 

### How easy is to add a new Scale  

Implement the `App\Service\Converter\ConverterInterface` and inject it inside the service `@App\Controller\Transformer\Prediction`. Dependency injection is something too easy and awesome ;) 

### Other comments

* Cache validation: I didn't add a cache system support because it's more about the infrastructure layer. I could to add a Proxy pattern on top of Repositories class to decide to use memcache or the partner api itself.

* What about choose 80% of code to coverage with tests? Normally I don't create unit tests to class on the infrastructure layer like Repositories (accessing databases, apis, etc.) cause it's normal that tests doesn't check anything. For example, developers add tests to repositories using ORMs, but normally its methods have not relevant algorithms to check. If the queries were written with typos, for example, test flux will not conver it. Other example is test anemic entities or object values covering getters and setters. 

* What I would like to do better? I've created two partners (BBC and WEATHERCOM) just to exemplify how different they could be. One of them receive temperatures in Fahrenheit, so it's important normalize it to Celsius, which is not necessary in the other one. To support both I've created two different repositories using different mock responses (xml and json). One of them uses a Hydrator class, what could be done to the second one too. The request validations is not so good, maybe we could separate the responsibilities to respect SOLID also in the application layer.  
I am too confortable with unit testing, but I abandoned the TDD during the process because of time and the whole application should have many other test cases but I think based on BBCTest and AccuracyCalculatorTest I could to show the most important skills about it. 
I was a little bit confused if I would like to show an avarege of the whole day or per hour. I choose the secound one since it's easier do the other option after.
I would like to create a frontend (even knowing that it's not a strong skill). The class ConverterInterface has two methods to implement and thinking in Interface segragation, it would be better break it in two others. 



### Request examples


```shell

GET /predictions?date=2018-06-07&amp;city=lisbon HTTP/1.1
Host: 0.0.0.0:8000
Cache-Control: no-cache

GET /predictions?city=lisbon HTTP/1.1
Host: 0.0.0.0:8000
Cache-Control: no-cache

GET /predictions HTTP/1.1
Host: 0.0.0.0:8000
Cache-Control: no-cache

GET /predictions?date=2017-08-07&amp;city=lisbon HTTP/1.1
Host: 0.0.0.0:8000
Cache-Control: no-cache


```