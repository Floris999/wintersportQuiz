# WintersportQuiz

**Description:** WintersportQuiz is a WordPress plugin designed to recommend ski resorts based on user preferences through a quiz.

**Author:** Dintify

**Author URI:** [https://floris999.github.io](https://floris999.github.io)

## Table of Contents

- [Description](#description)
- [Installation](#installation)
- [Usage](#usage)
- [Customization](#customization)
- [Changelog](#changelog)
- [License](#license)

## Description

WintersportQuiz is a WordPress plugin that provides a quiz to recommend ski resorts based on user preferences. Users answer a series of questions, and the plugin suggests the best ski resort for them.

## Installation

1. **Upload the plugin files to the `/wp-content/plugins/wintersportquiz` directory**, or install the plugin through the WordPress plugins screen directly.
2. **Activate the plugin** through the 'Plugins' screen in WordPress.
3. **Ensure the custom database tables are created** by activating the plugin. The activation hook will call the `create_custom_tables` function.

## Usage

1. **Add the quiz to a page or post** using the shortcode `[wintersport_quiz]`.
2. **Users can take the quiz** by answering a series of questions.
3. **The plugin will recommend a ski resort** based on the user's answers.

## Customization

### JavaScript and CSS

- **JavaScript:** The plugin uses jQuery for handling form submissions and animations. The main JavaScript file is located in `assets/script.js`.
- **CSS:** The plugin's styles are defined in `assets/style.css`.

### Adding Questions and Answers

- **Questions and answers** are defined in a JSON file located at `vragen_antwoorden.json`.
- **Edit the JSON file** to add or modify questions and answers.

### Controllers

- **FormController:** Handles form submissions and recommendations. Located in `controllers/FormController.php`.

## Changelog

### 1.0.0
- Initial release of WintersportQuiz.

## License

This plugin is licensed under the [MIT License](LICENSE).