# PHP

This architecture is based on [inuticss](https://github.com/inuitcss/inuitcss) framework.

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