WP Dependencies
==============

A composer package for WordPress to autoload plugin dependencies.

## Usage

### For Themes and Plugins

##### Register the Dependencies and WP Dependencies Package

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
            "type": "git",
            "url": "git@github.com:voceconnect/wp-dependencies.git"
        },
        {
            "type": "composer",
            "url" : "http://wp-plugins.packagist.voceconnect.com/"
        },
        ...
    ],
    "config": {
    	"vendor-dir": "plugins"
    },
    "require": {
        "voceconnect/wp-dependencies": "dev-master",
        "wpackagist/some-plugin-name": "~1.0"
        ...
    }
}
```

#### Add Composer's Autoload

Include Composer's ```autoload.php``` in the theme's ```functions.php``` or plugin's main file.

```
// bootstrap composer autoload for dependencies
if(file_exists( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'autoload.php' ) ) {
	include_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'autoload.php' );
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


### For a Project

##### Register the Dependencies and WP Dependencies

```
{
    "name": "my-account/my-project",
    "type": "project",
    "authors": [
        {
            "name": "John Doe",
            "email": "john@example.com"
        }
    ],
    "repositories": [
        {
            "type": "git",
            "url": "git@github.com:voceconnect/wp-dependencies.git"
        },
        {
            "type": "composer",
            "url" : "http://wp-plugins.packagist.voceconnect.com/"
        },
        {
            "type": "composer",
            "url" : "http://packagist.voceconnect.com/"
        },
        ...
    ],
    "config": {
    	"vendor-dir": "mu-plugins"
    },
    "require"     : {
        "voceconnect/wordpress": "~3.6.0",
        "my-account/my-theme": "dev-master",
        "wpackagist/memcached": "2.0.0",
        "wpackagist/nginx-compatibility": "~0.2.5",
        "wpackagist/wordpress-mu-domain-mapping": "~0.5.4",
        "voceconnect/wp-dependencies": "dev-master"
    },
    "require-dev" : {
        "wpackagist/debug-bar": "9999999-dev",
        "wpackagist/debug-bar-extender": "9999999-dev",
        "wpackagist/debug-bar-cron": "9999999-dev",
        "wpackagist/developer": "9999999-dev",
        "wpackagist/rewrite-rules-inspector": "9999999-dev",
        "wpackagist/log-deprecated-notices": "9999999-dev"
    },
    "extra"       : {
        "installer-paths": {
            "wp/": ["voceconnect/wordpress"],
            "wp-content/drop-ins/{$name}/": ["wpackagist/memcached"],
            "wp-content/mu-plugins/{$name}/": ["wpackagist/nginx-compatibility"]
        }
    }
}
```

##### Handling Drop-ins

Because WordPress require's it's drop-ins to be installed directly into the ```wp-content``` directory instead allowing them to be held within a containing folder, you will need to add a symlink for any drop-ins.  These symlinks should be added to the git repository.

```
> ln -s wp-content/drop-ins/memcached/object-cache.php wp-content/object-cache.php
```

##### Handling MU-Plugins

??????? - Since WordPress only loads single files directly in the ```wp-content/mu-plugins``` folder, we need to create a way to handle these.  We're already taking advantage of this by having Composer's ```autoload.php``` be added to the ```wp-content/mu-plugins``` directory by setting it as the vendor-dir. 