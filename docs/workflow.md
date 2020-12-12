# Worfklow

MixerAPI will not change your CakePHP workflows and is designed to augment your Cake development experience. Whether 
its Models, Controllers, Authentication, Authorization, Pagination, Events or anything else you love about CakePHP — 
MixerAPI is built to power the web, not get you caught in one.

## Development

Assuming your initial planning is complete, a typical workflow for building your APIs would involve, but not be 
limited to:

- Defining your schema using [migrations](https://book.cakephp.org/migrations/2/en/index.html).
- Baking your initial scaffolding using [bake](https://book.cakephp.org/bake/2/en/index.html) in conjunction with the 
[MixerAPI/Bake](/bake) theme.
- Building your [validations](https://book.cakephp.org/4/en/orm/validation.html) which not only provide input 
validation, but are also used to power your OpenAPI definitions and some response formats.
- Building your [RESTful routes](https://book.cakephp.org/4/en/development/routing.html#resource-routes) with or 
without [MixerAPI/Rest](/rest).
- Begin development using [SwaggerUI](/cakephp-swagger-bake/) as the interface to your API, though you can import 
the generated OpenAPI JSON into Postman as well.
- Setting up [Authentication](https://book.cakephp.org/authentication/2/en/index.html) and 
[Authorization](https://book.cakephp.org/authorization/2/en/index.html).
- Integrate [Search](/friends-of-cake-search) into your API.
- Decide on which Response Formats you want to support.
- While of course writing [unit tests](https://book.cakephp.org/4/en/development/testing.html) a long the way.
- And installing additional CakePHP [plugins](https://github.com/FriendsOfCake/awesome-cakephp) as needed.

## Support

If you find bugs or errors in the documentation, please report them to the 
[plugins repository](https://github.com/mixerapi) (or submit a PR).

- [MixerAPI Live Demo](https://demo.mixerapi.com)
- [MixerAPI Demo Source Code](https://github.com/mixerapi/demo)
- [CakePHP Documentation](https://book.cakephp.org/4/en/index.html)
- [CakePHP Code API](https://api.cakephp.org/4.0/)
- [CakePHP Slack](https://cakesf.slack.com/)
- [CakePHP StackOverflow](https://stackoverflow.com/tags/cakephp)