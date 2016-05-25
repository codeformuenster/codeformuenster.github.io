Code for Münster Homepage at [codeformuenster.org](http://www.codeformuenster.org).

# Step 1: Install jekyll locally to simulate github pages

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


# Step 2: Generate the Homepage

## Configuration

The project list on the frontpage will automatically be updated by fetching all the repositories of an organisation via the github api.

Create the file "_config.ini":

    cp _config.ini.dist _config.ini

Then enter your organisation name and github access keys.


## Update the project list on the homepage


You can even automatically create the screenshots, you just need to install shutter:

    sudo apt-get install shutter

Then you can update the repository list on the frontpage by running:

    php update-data.php




# Step 3: Run it

Compiles the page after saving a code change:

    bundle exec jekyll serve

The website is now available at http://localhost:3000




# Other useful things


## Update a single screenshot

Sometimes the screenshot generator generates ugly things, especially for javascript heavy pages.
Then use your favorite screenshot tool to take screenshots and then issue the following commands to resize the screenshot to appropriate size:

    convert screenshots-large/$repoName.png  -background white -resize 600x -crop 600x400+0+0 -strip -quality 80 $screenshot_file

    convert screenshots-large/wo-ist-markt.github.io.png  -background white -resize 600x -crop 600x400+0+0 -strip -quality 80 screenshots/wo-ist-markt.github.io.jpg
