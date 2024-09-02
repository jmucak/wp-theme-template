# wp-theme-template

## Table of contents

1. [Project info](#project-info)
2. [Requirements](#requirements)
3. [Installation](#installation)
4. [Development scripts](#development-scripts)
5. [Code style standards and best practices](#code-style-standards-and-best-practices)

### Project info <a id="project-info"></a>

Theme description

- repository: ``
- figma: ``

### Requirements <a id="requirements"></a>

- PHP > 8.1
- composer v2
- node v21 or higher
- npm v10 or higher

### Installation <a id="installation"></a>

#### Template setup
- Clone this repository in `/wp-content/themes` folder
- Change namespace in composer.json file from `wpThemeTemplate` to your project namespace
- Change namespaces in all classes inside app folder to your project namespace
- Run `composer install`

#### Environment setup

- Clone this repository in `/wp-content/themes` folder
- Run `composer install`
- Activate the theme through the 'Themes' screen in WordPress


### Development scripts <a id="development-scripts"></a>

- `npm run dev`: watches and compiles files on change
- `npm run build`: creates production ready versions of css and js inside `static` folder


### Code style standards and best practices <a id="code-style-standards-and-best-practices"></a>

#### PHP

- write clean and OOP code
- every class, functions or any logic should exists only in `app` folder

#### WordPress

- WordPress coding standards [github](https://github.com/WordPress/WordPress-Coding-Standards)
  and [docs](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/) should be applied
- exception of naming classes because of autoloader, classes should be named with CamelCase
- No shorthand PHP Tags => use `<?php ... ?>`
- Single and Double Quotes => If you’re not evaluating anything in the string, use single quotes
- Methods and Functions should be named with snake_case, Example: `get_posts(), get_data()`
- Brace Style => Braces should always be used in all code blocks, Example: `if($some_condition) { // Do something}`
- When declaring a function or a class braces are added at the end of the line, not in the new line
- Declaring Arrays => Arrays must be declared using long array syntax, Example: `array(1,2,3);`
- Using import use statements => Import `use` statements should be at the top of the file and follow the `namespaces`
  declaration