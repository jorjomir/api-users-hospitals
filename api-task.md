## Web Development API Task

The task is to create an API to manage a patient/doctor persistence layer. You are free to use the tools and technologies without any kind of frameworks you feel most confident with and that will present your work in the best possible light.

Your solution _must_:

- Expose a **user** model having the following attributes:
- **`id`** - _a unique user id_
- **`email`** - _a user's email address_
- **`first_name`** - _the user's first name_
- **`last_name`** - _the user's last name_
- **`type`** - _(patient or doctor)_
- **`workplace_id`** - _(hospital) - only IF a user is type doctor_
- **`created_at`** - _the date and time the user was added_
- Expose a **hospital** model having the following attributes:
- **`id`** - _a unique hospital id_
- **`name`** - _a hospital title_
- **`address`** - _a hospital physical address_
- **`phone`** - _a hospital phone number_
- Have the ability to persist user and hospital information for at least the lifetime of the test.
- Expose functionality to create, read, update and delete (CRUD) users and hospitals.
- Expose functionality to list users and the ability to search them by workplace and title.
- Expose functionality to list hopsitals and the ability to order them by employees count.
- Be easily consumable by a plain HTTP client e.g. cURL or Postman

If you feel like you want to show us what you are really capable of, here is a list of potential enhancements that we have come up with. You can always go the extra mile and do not limit yourself to it if you think of any other possible feature enhancement that you want to include in your submission.

- Provide a way for your API to be easily tested/consumed (e.g. a custom front-end, a [Postman](https://www.getpostman.com/) collection or a [Swagger/OpenAPI](https://swagger.io/) API specification).
- Use of an industry standard data exchange format.
- Sanitization checks of inputs.
- Implementation of test coverage.