# The "Code for Münster" Homepage

See a live example at [codeformuenster.org](http://www.codeformuenster.org).

The cool thing about this is, the fancy project list on the frontpage can automatically be fetched from the GitHub API by reading all the repositories of an organisation.

We are generating a static html page that can be hosted on github pages.

## How does it work?

* It would generate too many requests to the GitHub API if we would call the GitHub API live on every user request,  
* That is why there is a php script in this repository that can be called from the command line.
* It downloads all the repository meta data from GitHub and creates a summary json file that is then used by the static html frontpage.

# 1. Run jekyll locally to simulate github pages

## Install & run using Docker


1. Install [Docker](https://docs.docker.com/installation/#installation) 

2. Use this command to run it in docker.
Compiles the page after saving a code change:

Linux:

    docker run -it --rm -v "$PWD":/usr/src/app -p "4000:4000" starefossen/github-pages

Windows (PowerShell):

    docker run -it --rm -v ${pwd}:/usr/src/app -p "4000:4000" starefossen/github-pages

The website is available at [http://localhost:4000](http://localhost:4000). 

Now you can make design changes, etc.
Posts and stylesheets will automatically be recompiled on change.

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

# 2. Regenerate the project list

The project list will be created by fetching all sub-repositories from an organisation at github.

## Configuration

Create the file "_config.ini":

    cp _config.ini.dist _config.ini

Enter your organisation name and github access keys into the file.

## Github setup

* Every project of the organisation needs the following things set up:
  * The fields "Description" and "Website" need to be
filled out in Github (The "Description" will used as project description and the "Website" URL will be visited and a screenshot will be taken)
  * If the "Description" contains the string..
    * "obsolet" or "obsolete", then the repository will be excluded from the list.
    * "(neu)" then a *work-in-progress* icon will be shown.
    * "idee" then a *this-is-just-an-idea* icon will be shown.
    * "(down)" then a *site-is-currently-down* icon will be shown.
* Project Issues
  * A progress bar for the project will be generated by counting the percentage of closed vs. open issues, so if you want to display a progress bar, then you need to have some open and closed tickets on the project.
* README.md
  * Project preview image: If you want to show a different one than the auto-generated screenshot as preview image, then put an image into the README.md. The first image found in the README.md will be used as prview image for the project. IF no image is found, then a screenshot will be generated by visiting the Project Website.
  * You can put a variable block with a status value into the README, like this:
  https://raw.githubusercontent.com/codeformuenster/open-data/master/README.md
  If a status value of "ok" or "done" is found, then the project will be displayed as finished.

## Update the project list on the homepage

First you need to install "shutter", so that it can automatically create the screenshots of your repositories:

    sudo apt-get install shutter

Then you can generate the metadata json file that is used to render the repository list on the frontpage, by running:

    php update-data.php

### Update project list without installing php

The downside to this approach is, that screenshots will not be generated automagically, but you can create the screenshots manually (see last section of README)

    docker run --rm -v $(pwd):/app -w /app php:cli php update-data.php 14

### Update the users list on the homepage with Docker

1. get yourself a GitHub API Key [here](https://github.com/settings/tokens). The key needs to have the permission `repo:status`. Put in in `update_members_docker.sh` behind `GITHUBTOKEN=`. 

2. build the update container with `containers/update_members/make_docker_container.sh`

3. run the update script `./update_members_docker.sh`

## Deploy your changes to github

* Commit the files  _json/*.json_
* Commit the file _index.html_
* Push it to the gh-pages branch.
* Done!

# Other useful things

## Generate a single screenshot

    npx pageres-cli http://www.google.com

## Create correct screenshot size

Sometimes the screenshot generator generates ugly things, especially for javascript heavy pages.
Then use your favorite screenshot tool to take screenshots and then issue the following commands to resize the screenshot to appropriate size:

    convert screenshots-large/$repoName.png  -background white -resize 600x -crop 600x400+0+0 -strip -quality 80 $screenshot_file

    convert screenshots-large/wo-ist-markt.github.io.png  -background white -resize 600x -crop 600x400+0+0 -strip -quality 80 screenshots/wo-ist-markt.github.io.jpg
