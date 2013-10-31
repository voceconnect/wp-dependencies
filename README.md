WP Dependencies
==============

A composer package for WordPress to autoload plugin dependencies.

## Usage

### For Themes and Plugins

##### Require the Dependencies and WP Dependencies Package

Add a reference to wp-dependencies to your theme's or plugin's composer.json along with
any other plugins that need to be active.

```
{
    "name": "my-account/my-theme",
    "type": "wordpress-theme",
    "authors": [
        {
            "name": "John Doe",
            "email": "john@example.com"
        }
    ],
    "repositories": [
        {
            "type": "composer",
            "url" : "http://wp-plugins.packagist.voceconnect.com/"
        },
        ...
    ],
    "config": {
    	"vendor-dir": "vendor"
    },
    "require": {
        "voceconnect/wp-dependencies": "~0.1",
        "wpackagist/thermal-api: "~0.7"
        ...
    }
}
```

#### Add Composer's Autoload

##### For WordPress Projects

Because of the way WordPress loads, it is suggested that the ```mu-plugins``` directory be set as the vendor.  This allows Composer's ```autoload.php``` to be loaded automatically after WordPress' plugin API has already been setup.

```
{
    ...
    "config": {
        "vendor-dir": "wp-content/mu-plugins"
    },
    ...
}
```

#### For WordPress Themes or Plugins

Include Composer's ```autoload.php``` in the theme's ```functions.php``` or in your plugin's main file.  The below example assume's the plugin's or theme's ```vendor-dir``` setting ```composer.json``` is set to ```vendor```.

```
// bootstrap composer autoload for dependencies
if(file_exists( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php' ) ) {
	include_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php' );
}
```

#### Load Dependencies

For dependencies or plugins that do not autoload through composer, you will need to load the dependency through one of two ways.

```
do_action( 'wp_load_dependency', 'some-plugin-name', 'main-plugin-file.php');
```

or

```
if (function_exists('wp_load_dependency')) {
	 wp_load_dependency('some-plugin-name', 'main-plugin-file.php');
}
```

The former action based loading is preferred as it provides more flexibility for future iterations.
