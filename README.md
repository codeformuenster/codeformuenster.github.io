Code for Münster Homepage at [codeformuenster.org](http://www.codeformuenster.org).

## Install & run using Docker

(These instructions are for Linux. On OSX/Windows, Docker has to be installed
differently.)

* Install [Docker](https://docs.docker.com/installation/#installation) and [Fig](http://www.fig.sh/).
* Then run: `sudo fig up`

The website is now available at [http://localhost:4000](http://localhost:4000). Posts and stylesheets will automatically be recompiled on change.

## Non-Docker Install

This site is build using jekyll.

    sudo gem install jekyll
    sudo gem install rdiscount
    sudo gem install bundler

Install dependencies:

    bundle install

### Change Stylesheets

The stylesheets are written in SASS/SCSS and are found in folder `_sass`. After changing the code you must compile manually to CSS with:

    compass compile

Or run `compass watch` to automatically recompile after saving a file. If you intend to run the webserver as well, you don't need to compile the SASS code by hand. It is then managed by `bundler`/`jekyll`.


### Run

Compiles the page after saving a code change:

    bundle exec jekyll serve

The website is now available at http://localhost:3000


# How to update the project list on the homepage

The project list can automatically be updated by fetching project data via the github api.

You can even automatically create the screenshots, you just need to install shutter:

    sudo apt-get install shutter

Then you can update the data by running:

    php update-data.php
