# Requirements
- Docker (compose)
- Postman

# Setup
- Run ```$ cp .env.example .env```
- Run ```$ docker-compose up --build```
- Import `./WheaterApp.postman_collection.json` into your postman application

# Extras
If you want to run the debugger, XDEBUG is configured on port 9003 on the docker php container.

## The corners I cut
#### Data should be shown in a human readable format
 > Human readable format should be "On 2022-01-06 at 01:00 the temperature is 10c" but to meet the technical requirements
 > and have he api usable I opted for a rest-like api output.

#### Using the input date compared to the provider date
> Ofcourse the exercise was to see if the input date was not lesser than the current date and not more than current_date+10 days.
> I have taken this into account but the fact that the provider date was from 2018 I thought it would make more sense to validate
> at our end instead of comparing it to a three-year-old date.
> In a real world example I would've queried the providers with the input date.

#### Selecting the forecast for the city
> There was no real use for it since all the provider-data was located in "amsterdam", so creating more provider data would be wasteful of my time and out of the exercise bounds.

#### Mocking the provider data
> I didn't really know how to interpret "mocking the provider data" so I've included them into the /public directory
> and selected the file-contents from there.

#### UML Diagrams
> I really have no experience at all with documenting my code using UML diagrams, I'd love to learn more about the process
> and think it is very important. But I have chosen not to waste a lot of time on that right now since it would cut drastically into the assignment time.

#### XML Parsing with SimpleXMLElement
> Since I don't have much experience parsing XML I went the quick-and-dirty route just to keep the time for this exercise at a minimum.
> In a real world example I would've used the proper use-case.

# What I would test
> To get the highest coverage rating with the least effort I would test everything BUT the parsing of the provider data.
> The parsing of the provider data could change but the data is outside our domain it is not really effective to test.
> The most important test would be how we generate the weather report with multiple providers, and how we convert the temperature-scales.
