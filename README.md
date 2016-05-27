# ACF Taxonomy Selector Field

- Contributors: [@mcaskill](https://github.com/mcaskill), [@timperry](https://github.com/timperry)
- Tags: footnotes, endnotes, shortcode, references
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
- Requires at least: 3.4
- Tested up to: 5.3
- Stable tag: 1.0

The _Taxonomy Selector_ field allows the selection of one or more taxonomies.

## Description

Provides a new field type, for the [Advanced Custom Fields](https://www.advancedcustomfields.com/) WordPress plugin, which  allows users to select of one or more taxonomies.

The field is based on [Tim Perry's _Post Type Selector_](https://github.com/TimPerry/acf-post-type-selector) field type.

## Compatibility

This ACF field type is compatible with:

- ACF 5
- ACF 4
- ACF 3

## Installation

The field type can be used as [_plugin_](https://codex.wordpress.org/Plugins), [_must-use plugin_](https://codex.wordpress.org/Must_Use_Plugins), a _[Composer](https://getcomposer.org) package_, and a _theme include_.

### Via Composer

```
$ composer require mcaskill/acf-field-taxonomy-selector
```

### Via WordPress Admin Panel

1. Download the [latest ZIP](https://github.com/mcaskill/acf-field-taxonomy-selector/releases/latest) of this repo.
2. In your WordPress admin panel, navigate to _Plugins_ → _Add New_.
3. Click _Upload Plugin_.
4. Upload the ZIP file that you downloaded.

### Activation

Then activate the plugin via [wp-cli](http://wp-cli.org/commands/plugin/activate/).

```
$ wp plugin activate acf-field-taxonomy-selector
```

Or through the WordPress admin panel (_Plugins_ → _ACF Taxonomy Selector_ → _Activate_).

### Via Theme

1. Download the [latest ZIP](https://github.com/mcaskill/acf-field-taxonomy-selector/releases/latest) of this repo.
2. Extract the plugin from the ZIP file you downloaded.
3. Upload the directory into your theme's directory.
4. Edit your theme's `functions.php` file to include the plugin's main PHP file:

	```php
	add_action( 'acf/register_fields', 'register_my_acf_fields' );

	function register_my_acf_fields()
	{
        include_once '{acf-taxonomy-selector}/acf-taxonomy-selector.php';
	}
	```

## Usage

### Get Field Value

```php
$taxonomy_name   = get_field('taxonomy');
$taxonomy_object = get_taxonomy( $taxonomy_name );

echo '<h2>' . $taxonomy_object->label . '</h2>';

$terms = get_terms( $taxonomy_name );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    echo '<ul>';
    foreach ( $terms as $term ) {
        echo '<li>' . $term->name . '</li>';
    }
    echo '</ul>';
}
```

## Changelog

### 0.1.0

- Initial Release
