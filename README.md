# Grav tidyhtml plugin

[Clemens Queissner](https://cq-design.de)

# Requirements

This plugins requires you to have the PHP module `tidy` installed.
Check out the official [PHP doc](http://php.net/manual/en/book.tidy.php).

# Installation

The tidyhtml plugin is easy to install with GPM.

```
$ bin/gpm install tidyhtml
```

Or clone from GitHub and put in the `user/plugins/tidyhtml` folder.

```
$ git clone git@github.com:sourcesoldier/grav-plugin-tidyhtml.git tidyhtml
```

# Usage

The plugin is enabled by default, if you want to disable it make sure to place a `tidyhtml.yaml` file in the `user/config/plugins/` directory.

Most of the settings already applied to the defaults are most common to the HTML5 standard. Checkout the plugin settings in the admin panel to modify the settings to your needs.

## Disabled output processing on a per-site basis

If you need to disable tidy processing on a site basis you must add the site-node to the list of *ignore_pages* in the config. For more convenience you can use the settings in the admin panel of the plugin.