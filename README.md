# codeformuenster.org

This repository contains the source code of our homepage [codeformuenster.org](https://codeformuenster.org/).

The site is being built with [jekyll](https://jekyllrb.com/) and is hosted on [GitHub Pages](https://pages.github.com/).

We're using a very fine theme called [bulma-clean-theme](https://github.com/chrisrhymes/bulma-clean-theme) with some modifications. The original theme is created by [Chris Rhymes](https://www.csrhymes.com/) and is licensed under the [MIT license](https://github.com/chrisrhymes/bulma-clean-theme/blob/master/LICENSE.txt)

## Development

sudo docker run -it --rm -v "$PWD":/usr/src/app -e JEKYLL_GITHUB_TOKEN=my-github-token -p "4000:4000" starefossen/github-pages

### I want to add an image to the front page carousel

- Add your image to `assets/img/carousel`
- Add the filename to the `carousel_images` array in `index.md`
- Change the `$numberOfImgs` variable in `assets/css/app.scss`
