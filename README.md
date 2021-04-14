# ESD-HealthIsWealth

Our application helps our users to analyse their food, share their diet with their friends, receive recommendations from our analysis trends and understand their calories input and output!

## Getting Started

We have docker-compose.yml files which consist of the necessary technologies to keep these microservices running.

Following the steps below from the prerequisites till the end of the installation guide will ensure that our application runs smoothly on your end.

These instructions will cover usage information for the docker containers and files. In addition, it will help our application be up and running on your local machine for development and testing purposes. 

# Things to Note:

GraphQL Link might change when the dynamic link expires. do inform us if you are unable to access the data at our database at shunhui.lee.2019@sis.smu.edu.sg, ycyeo.2019@sis.smu.edu.sg, lxhong.2019@sis.smu.edu.sg, trisha.chua.2019@sis.smu.edu.sg, zhyeong.2019@sis.smu.edu.sg.

Do not use WAMP to test the sharetoLinkedIn microservice, as there is an SSL certificate issue. This microservice works on MAMP. Please contact ycyeo.2019@sis.smu.edu.sg if you would like to change the config.php callback URL.

### Prerequisites

What are the things you need to install the software and how to install them:

In order to run this container, you will need docker installed.
There are links below that leads you to the installation of Docker.

https://docs.docker.com/get-docker/

Compatible with: 

MacOS

Windows

Linux

Documentation for Docker

https://docs.docker.com/

Open the project folder. An example of the project root folder will be:

Mac:
/Downloads/ESD-HealthIsWealth
/Applications/MAMP/htdocs/ESD-HealthIsWealth 

Windows:
C:/wamp/www/ESD-HealthIsWealth
C:/Users/<YourUsername>/Downloads/ESD-HealthIsWealth

After navigating to the project directory, perform docker-compose up.

Once everything is up and running, navigate to localhost:1337

Create a new admin account if necessary, and put the following details for your connection:
Name: default
Kong Admin URL: http://kong:8001

Navigate to snapshot, located at the side bar and import the json file located at kong/development.json.

# ALTERNATIVE
You may proceed to our website at http://34.121.93.98.xip.io/ if you would like to use our deployed application rather than view individual components

Please Note: several networks may block our IP as we do not have an SSL certificate enforced or a domain name registered.


## Built With

##### Python Libraries:
Flask
SQLAlchemy
Graphene
Graphene_SQLAlchemy
Flask_GraphQL
DateTime
os
sys
requests
Pika
Json
random
flask_cors
google.auth.transport
google.oauth2

##### Node Libraries:
cors
express

##### PHP Libraries
PhpAmqpLib
GuzzleHttp

##### Front End Framework
Vue.JS
BootStrap

##### Back End Framework
Php
RabbitMQ
NodeJS
ExpressJS

##### Database Framework
Hasura
GraphQL

##### Deployment Framework
Heroku
Google Cloud

##### External Dependencies / API
EDANAM
CalorieNinjas
Clarifai
TelegramAPI
LinkedInAPI
GoogleAPI
Imgur

### Functionalities 

#### Image Analyser Functionality 
-- We allow users to drag or drop any image into the upload box, and upon uploading, the microservice will process the files and it will go through a series of conversion, breaking down the image, before returning the results with suggested results.

##### Comprehensive Function

Upon uploading the image, the image will then be uploaded to the imgur server. It will then return a JSON object to our microservice. Subsequently, we will extract the imgur link of the image from the JSON object, before passing the link into Clarifai API which scans what the image could be. It will then return a JSON object result which we will extract the highest possible result, before passing them to back to our complex microservice which communicate with the EDAMAM API. Our complex microservice will then return a list of possible recipes which can be deduced from the results, displaying all health information and recipe information to the user and providing them with a link to share to their LinkedIn account too!

#### Exercise Scheduling Functionality

-- We allow users to exercise and challenge their calories output by taking up our random exercise generator challenge. All the users need to do is to input their preference of Easy, Medium or Hard and their preferred duration of exercise. The functionality will generate an exercise and input it into their Google Calendar, and they will be notified on Telegram.

##### Comprehensive Function

Upon selecting a date, the user will be prompted with a modal overlay which prompts them for their preference. After submitting their preference, the microservice will obtain their input via a POST request, which will allow them to randomly generate a function from the database. This way, they will be able to obtain all the possible exercises from the database based on the user's preference. A random function will be called which calls a random exercise from the selected possible exercises from the database and be returned to the user's interface. This will automatically be added into his Google Calendar. The microservice will then send the random generated exercise to the telegram bot, which will invoke the accountsManagement microservice which calls the user's telegram chat id. This way, the telegram bot will then send a notification to the user, letting them know that the exercises' details and the exercises are successfully added.

#### Plan a Meal Functionality

-- We allow users to plan a meal for the day, indicating how much nutrition the food they intend to consume offers. Subsequently, if the food they plan to eat has too much calorie intake based on their preference, the system will prompt them that they are should not plan for more food as there is a health concern. Upon creating their meal plan, it will then be saved into the database for the user to track what food they have consumed and they will be notified on Telegram that their meal is planned!

##### Comprehensive Function

Upon arriving at the Plan a Meal UI, the user will be able to search for the food they planned. The microservice will invoke the calorieNinjas API which provides them with a comprehensive nutrition list about the food that they searched for. If the user is satisfied, they can add the food into their plan. After adding a certain bunch of food which amounts to a high calorie intake, a notification will be prompted, indicating health problems. Then, upon clicking on creating a meal, the meal will be added into the database, invoking getMealHistory, which will add their newly planned meal into the database. Then, it will invoke the accountManagement Microservice which calls the user's telegram chat id. This way, the telegram bot will then send a notification to the user, letting them know that the planned meals details and the planned meal is successfully added. Lastly, getMealHistory will then be invoked to obtain the meal history of the user, before displaying it on the Landing_Plan UI.

## Versioning

We use [Git](https://ourcodingclub.github.io/tutorials/git/) for versioning. For the versions available, see the [repository](https://github.com/Shun-97/ESD-HealthIsWealth/tags). 

## Authors

* **Lee Shun Hui** - *Back-End Developer* - [Lee Shun Hui](https://github.com/Shun-97)
* **Yeo Yao Cong** - *Front-End Developer* - [Yeo Yao Cong](https://github.com/izhcong1997)
* **Hong Li Xuan** - *Architecture Design* - [Hong Li Xuan](https://github.com/h-lixuan)
* **Chua Zihui Trisha** - *Quality Assurance API Tester* - [Trisha Chua](https://github.com/trishachua2019)
* **Kendrick Yeong** - *Marketing* - [Kendrick Yeong](https://github.com/kendrick-bit)

See also the list of [contributors](https://github.com/Shun-97/ESD-HealthIsWealth/graphs/contributors) who participated in this project.


## Acknowledgments
- FullCalendar (https://fullcalendar.io/)
- Moments.js (https://momentjs.com/docs/)

* Other than that, We did not plagiarize any code from our friends, seniors nor any online repository
