# PHP

## app folder logic structure

- `/acf-json` - ACF json files
- `/controllers`
  - Purpose: handle user interactions, such as form submissions or AJAX requests
  - Usage: manage logic for routing, handling requests and processing data(processing form submissions or API requests)
- `/factories`
    - Purpose: responsible for creating instances of objects or classes
    - Usage: encapsulate complex object creation logic
- `/models`
    - Purpose: represent data entities and interact directly with the WP database
    - Usage: fetch and manipulate data from the database (get posts, save custom fields etc.)
- `/repositories`
    - Purpose: provide an abstraction over models to handle complex or multiple data queries
    - Usage: handle complex data retrieval (fetching posts with metadata or tax query)
- `/services`
    - Purpose: handle specific business logic. Services interacts with models or repositories but do not handle database access directly
    - Usage: manage complex operations like form validation, sending notification or actions across different parts of the system, custom widgets, shortcodes and custom wp-cli commands can be also placed here
- `/middlewares`
    - Purpose: handle requests before they reach the main logic  
    - Usage: validate or filter requests (checking user authentication)
- `/validators`
    - Purpose: validate user input such as form submissions
    - Usage: ensure that data input is clean and valid (sanitizing inputs, validating email addresses)
- `/helpers`
    - Purpose: Simple, reusable functions for common tasks like formatting or template loading
    - Usage: use for small, repetitive tasks like date formatting, text manipulation etc.
- `/hooks`
    - Purpose: WP actions and filters
    - Usage: for general hooks that aren't closely tied to a specific component or feature.
- `global-functions.php` - global theme functions

## Classes

- `/controllers/MovieController`
  - REST CRUD for movie cpt => Example
  - can call helper, service, models and repositories inside of this class
- `/helpers/ImageHelper`
  - helper class for image handling, uses ImageService from wp-image-pack
- `/providers/BlockProvider`
  - data for registering acf gutenberg blocks
- `/providers/ConfigProvider`
  - config data for service providers
- `/providers/CPTProvider`
  - data for registering custom post types and taxonomies
- `/providers/RESTProvider`
  - data for registering custom rest routes
- `/providers/ThemeServiceProvider`
  - main theme class
  - register services
  - init theme functionalities
- `/repositories/PostRepository`
    - extended WP_Query class
    - can be used in more specific way for specif post type
- `/repositories/TaxonomyRepository`
    - class for getting terms in WordPress, can have more methods relevan to the project
- `/services/BlockService`
  - reusable ACF Block logic
  - can be extended for a specific block
- `/services/MovieService`
    - example CPT movie logic for CRUD operation
    - specific functionalities for movie cpt
    - can have helpers, other services, repositories and even providers inside of service class, but must be added as dependency injection