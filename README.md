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

The plugin is enabled by default, if you want to disable it make sure to place a `tidyhtml.yaml` file in the `user/config/plugins/` directory
# Things still missing

- Using the blueprint.yaml to specify the config settings
- Making sure the php extension is available before running the method