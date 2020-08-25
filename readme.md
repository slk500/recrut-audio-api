I always trying to make things much more simpler & to use as less code and tools as possible.
* routing
  for fast prototyping I have used annotations - in enterprise I prefer yaml
* headers
  to make it more simple I give up headers:
  'HTTP_X-Requested-With' => 'XMLHttpRequest',
  'CONTENT_TYPE' => 'application/json',
* next steps
  - decouple controller from HTTP Request -> json_decode($request->getContent(), true); -> can be turn to eventSubscriber to convert json to array
  - MoneyType - its only one currency so - so I store money as int - otherwise should be refactored & add type/converter for Doctrine to store in database.
  - exception handling! - see my pet project fighterchamp - class -> https://github.com/slk500/fighterchamp/tree/master/src/AppBundle/ApiProblem
  - validation! - I validate input based on symfony form component - like this ->  https://symfonycasts.com/screencast/symfony-rest2/validation-errors-response
  - add docker - example in my pet project https://github.com/slk500/fighterchamp/blob/master/docker-compose.yml