# Scholar Crawl Plugin

![Version](https://img.shields.io/badge/version-1.2-blue)
![WordPress](https://img.shields.io/badge/wordpress-5.0%2B-brightgreen)

A simple WordPress plugin to scrape Google Scholar profile data and display it on your site.

## Description

The Scholar Crawl Plugin allows you to fetch and display data from Google Scholar profiles, including the profile picture, name, institution, and publications. It provides a customizable shortcode to specify the user ID and whether to show or hide the profile information.

## Features

- Fetch profile picture, name, and institution from Google Scholar.
- Display a list of publications with titles and publication years.
- Customizable shortcode to specify Google Scholar user ID and profile visibility.
- Easy to install and use.

## Installation

1. Download the plugin files.
2. Upload the `scholar-crawl-plugin` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

To use the plugin, add the following shortcode to any post or page:

### Show Profile Information

```plaintext
[scholar_crawl user="QcPyFTkAAAAJ" show_profile="true"]
