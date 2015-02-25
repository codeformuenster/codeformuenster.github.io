FROM ruby:2.2.0

# Set UTF-8 locale
ENV LC_ALL C.UTF-8

COPY Gemfile /usr/src/app/
COPY Gemfile.lock /usr/src/app/
WORKDIR /usr/src/app
RUN bundle install -j 4

COPY . /usr/src/app

CMD ["jekyll", "serve"]
EXPOSE 4000
