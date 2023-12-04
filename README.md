# Plugin Name: WP AM Vue App Plugin

## Plugin Description
This WordPress plugin creates an admin-only accessible Vue app with three tabs: one displaying a graph, one displaying a table, and one containing a settings form. The plugin uses Vue for the front-end, and you can choose between Vuex or Pinia for state management. It adheres to WordPress.org standards, focusing on proper data handling, translation support, and clean code architecture.

## Installation
1. Clone or download the plugin from the repository.
2. unzip the download file
3. Upload the entire `wp-am-vue-app` folder to your WordPress plugin directory.
4. Activate the plugin through the WordPress admin dashboard.

## Development
To set up the development environment, follow these steps:


```sh
git clone https://github.com/ikamal7/wp-am-vue-app.git

# Go to that plugin folder
cd wp-am-vue-app

# Install composer dependencies.
composer install

# Install npm dependencies.
npm install

# Run Dev server
npm run dev

# Build plugin
npm run build
```


## PHP Coding Standard check and fix

```sh
# Check if any PHPCS issues found.
composer run phpcs

# Fix any possible PHPCS issues.
composer run phpcs:fix
```

## PHP Unit test

```sh
composer run test
```


## API Endpoints
### 1. Get Data (GET)
- **Endpoint:** `/wp-am-vue-app/v1/data`
- **Description:** Retrieves data from the remote API [https://miusage.com/v1/challenge/2/static/](https://miusage.com/v1/challenge/2/static/). Caches results for one hour.
- **Authentication:** Requires administrator role user.

### 2. Update Single Setting (POST)
- **Endpoint:** `/wp-am-vue-app/v1/settings`
- **Description:** Saves changes to a single setting value. Applies sanitization, validation, capability, and nonce usage according to WordPress best practices.
- **Authentication:** Requires administrator role user.

### 3. Get All Settings (GET)
- **Endpoint:** `/wp-am-vue-app/v1/settings`
- **Description:** Returns all settings values.
- **Authentication:** Requires administrator role user.

## Plugin Functionality
### User Interface (UI)
- The plugin adds a top-level menu item in the WordPress admin dashboard for administrator-level users.
- Handles cases where JavaScript is disabled by displaying a simple error message.
- The Vue app's design is inspired by the WordPress plugin "WP Mail SMTP."

### Tabs
- The Vue app consists of three tabs: "Table," "Graph," and "Settings," controlled via Vue Router.
- Users can navigate between tabs without a page refresh.
- On the initial load, the "Table" tab is displayed by default.
- After a page refresh, users return to the last active tab.

### Settings Tab
- The "Settings" tab contains a form with three inputs:
  1. A numerical input field to set the number of rows to display in a table (1-5 inclusive, default: 5).
  2. A checkbox or radio toggle to switch between human-readable and Unix timestamp date formats (default: human-readable).
  3. A repeatable text field for entering up to five email addresses, with the WordPress admin email pre-populated (removable).

- Settings are initialized from the "get all settings" endpoint and saved in Vuex state and the database.
- Implements standard on-screen error handling for form validation.
- Vuex state is updated only upon a successful server setting update.

### Table Tab
- Uses the data endpoint to display a table of data returned from the data endpoint.
- Respects the settings for the number of rows and date format.
- Updates the displayed data based on changes made in the settings tab.
- Displays the list of emails from the settings as an unordered list below the table.

### Graph Tab
- Displays a simple graph of the data from the data endpoint.
- Can use any charting library for creating the graph.

## Notes
- Please ensure the plugin adheres to WordPress.org standards for security and quality.
- Your code quality and attention to detail will be evaluated.

## Credits
Plugin developed by Kamal Hosen

## License
This plugin is licensed under the GNU General Public License v3 or later.
