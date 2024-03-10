# codeformuenster.org

This repository contains the source code of our homepage [codeformuenster.org](https://codeformuenster.org/).

The site is being built with [jekyll](https://jekyllrb.com/) and is hosted on [GitHub Pages](https://pages.github.com/).

We're using a very fine theme called [bulma-clean-theme](https://github.com/chrisrhymes/bulma-clean-theme) with some modifications. The original theme is created by [Chris Rhymes](https://www.csrhymes.com/) and is licensed under the [MIT license](https://github.com/chrisrhymes/bulma-clean-theme/blob/master/LICENSE.txt)

## Development

```bash
    # Using docker-compose (recommended)
    sudo docker-compose up

    # Using docker run (deprecated)
    sudo docker run -it --rm -v "$PWD":/usr/src/app -e JEKYLL_GITHUB_TOKEN=my-github-token -p "4000:4000" starefossen/github-pages@sha256:5097d63b50e7a894b694761ded6ace912aa901b98f283824801db649ddb37684 jekyll serve --drafts --unpublished --future --host 0.0.0.0
```

Remove the `-e JEKYLL_GITHUB_TOKEN=my-github-token` option if you don't have a GitHub token handy (The GitHub API credentials you provided aren't valid.)

**Error "You have already activated X, but your Gemfile requires Y"?**

Deleting your `Gemfile.lock` should solve the problem.

### I want to add an image to the front page carousel

- Add your image to `assets/img/carousel`
- Add the filename to the `carousel_images` array in `index.md`
- Change the `$numberOfImgs` variable in `assets/css/app.scss`

### I want to add a project

- Open `_data/projects.yaml`
- Add your project in the following form

      repositoryname:
        title: The title of the project
        project_url: The url of the project (optional github project url will be used if missing)
        image: the file name of the project image. File should be in assets/img/projects
        showcased: true/false

- If your project should be showcased, add an image to assets/img/projects

### I want to add a blog post

- Create a new file in the `_posts` directory with filename `YYYY-MM-DD-title.md`
- The date `YYYY-MM-DD` represents the blog posts publishing date
- Your post should start with a frontmatter like this:

      ---
      layout: post
      title: Open Data Day 2018 in Münster
      author: Anthony Author
      twitter: your_twitter_handle
      category: blog
      ---

- Future posts won't be rendered on the live page

### I want to add an event

- Open `_data/events.yaml`
- Add event in the format of the other events
- Only next 4 events will be shown
- Events older than today will automatically disappear as soon as the github-page is regnerated (e.g. after a PR is merged)

### I want to add a press article

- Open `_data/presse.yaml`
- Add the article in the following form


      - wann: YYYY-MM-DD
        wer: Káseblatt des Westens
        thema: Lobhudelei der Open-Data-Schergen aus Münster
        link: https://kaseseblatt.org/posts/codeformuenster-ist-einfach-toll
